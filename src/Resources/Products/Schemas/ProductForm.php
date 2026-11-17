<?php

namespace SOSEventsBV\Cms\Resources\Products\Schemas;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use SOSEventsBV\Cms\FilamentComponents\SeoSettings;
use SOSEventsBV\Cms\Models\Currency;
use SOSEventsBV\Cms\Api\LeisureKingClient;

class ProductForm
{
    public static function lkApi(): LeisureKingClient
    {
        return new LeisureKingClient();
    }

    /**
     * Executes the synchronization action with LeisureKing API to fetch assortment data
     * and map it to the local application state.
     *
     * @return Action Returns the configured action for syncing data with LeisureKing.
     */
    public static function executeLkSyncAction(): Action
    {
        return Action::make('fetchAssortment')
            ->icon(Heroicon::ArrowPath)
            ->tooltip(__('cms::products.leisureking.fetch_tooltip'))
            ->action(function (Get $get, Set $set) {
                $leisurekingId = $get('leisureking_id');
                if (empty($leisurekingId)) return null; // Return null if leisureking_id is empty

                // Function to check if a field is excluded from syncing with LK
                $syncs = fn(string $field): bool => !$get("excluded_fields_lk_sync.{$field}");

                // Get assortment data from LeisureKing
                try {
                    $assortmentData = self::lkApi()->request('/assortment/getAssortmentDataByAssortmentId', [
                        'id_assortment' => $leisurekingId,
                    ]);
                } catch (\Exception $e) {
                    return Notification::make()
                        ->title(__('cms::products.leisureking.error_title'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }

                // If prices are not excluded, set the prices from LeisureKing
                if ($syncs('prices')) {
                    $priceGroups = collect($assortmentData['block_options'])
                        ->groupBy(fn($block) => number_format($block['price'], 2, '.'))
                        ->map(fn($blocks) => [
                            'id_block' => $blocks->first()['id_block'],
                            'from' => $blocks->first()['starttime'],
                            'to' => $blocks->last()['starttime'],
                        ]);

                    $euroId = Currency::where('code', 'EUR')->value('id');

                    $prices = $priceGroups->flatMap(function ($group) use ($leisurekingId, $euroId) {
                        $tarifs = self::lkApi()->request('/assortment/getTarif', [
                            'id_assortment' => $leisurekingId,
                            'id_block' => $group['id_block'],
                        ]);

                        return collect($tarifs)->map(fn($tarif) => [
                            'currency_id' => $euroId,
                            'amount' => number_format($tarif['price'] / 100, 2, ','),
                            'label' => $tarif['description'],
                            'includes_vat' => true,
                            'from' => $group['from'] === '00:00:00' ? null : $group['from'],
                            'to' => $group['to'] === '00:00:00' ? null : $group['to'],
                        ]);
                    })->values()->toArray();

                    $set('prices', $prices);
                }

                // Set fields that are not excluded from syncing with LK
                if ($syncs('name') && $assortmentData['display_name']) {
                    $set('name', $assortmentData['display_name']);
                    $set('page_title', $assortmentData['display_name']);
                }
                if ($syncs('description') && $assortmentData['description_long']) {
                    $set('description', $assortmentData['description_long']);
                }
                if ($syncs('summary') && $assortmentData['i18n']['nl']['description_short']) {
                    $set('summary', $assortmentData['i18n']['nl']['description_short']);
                    $set('page_description', $assortmentData['i18n']['nl']['description_short']);
                }
                if ($syncs('min_persons') && $assortmentData['minpax']) {
                    $set('min_persons', $assortmentData['minpax']);
                }
                if ($syncs('max_persons') && $assortmentData['maxpax']) {
                    $set('max_persons', $assortmentData['maxpax']);
                }
                if ($syncs('location') && $assortmentData['start_location'] && is_array($assortmentData['start_location'])) {
                    $loc = $assortmentData['start_location'];
                    $set('location', implode(' ', [
                        $loc['address'] . ',',
                        $loc['postcode'],
                        $loc['city'] . ',',
                        $loc['country']['name'],
                    ]));
                }

                // Returns success notification
                return Notification::make()
                    ->title(__('cms::products.leisureking.success_title'))
                    ->body(__('cms::products.leisureking.success_body'))
                    ->success()
                    ->send();
            });
    }

    /**
     * Creates an action to toggle the LK sync status for a given field.
     *
     * @param string $field The field for which the LK sync action is being created.
     * @return Action The configured action instance for toggling the LK sync status.
     */
    public static function lkSyncAction(string $field): Action
    {
        return Action::make('excluded_fields_lk_sync_' . $field)
            ->label(
                fn(Get $get): string => $get("excluded_fields_lk_sync.{$field}")
                    ? __('cms::products.leisureking.sync_disabled')
                    : __('cms::products.leisureking.sync_enabled')
            )
            ->tooltip(fn(Get $get): string => $get("excluded_fields_lk_sync.{$field}")
                ? __('cms::products.leisureking.sync_disabled')
                : __('cms::products.leisureking.sync_enabled'))
            ->icon(Heroicon::ArrowPath)
            ->color(
                fn(Get $get): string => $get("excluded_fields_lk_sync.{$field}")
                    ? 'gray'
                    : 'success'
            )
            ->action(fn(Set $set, Get $get) => $set(
                "excluded_fields_lk_sync.{$field}",
                !$get("excluded_fields_lk_sync.{$field}")
            ));
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('excluded_fields_lk_sync'), // Hidden field to save fields that do not sync with LK

                Tabs::make('Tabs')
                    ->tabs([

                        // ─── 1. BASIS ────────────────────────────────────────
                        Tabs\Tab::make(__('cms::products.tabs.basic'))
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('slug')
                                        ->label(__('cms::products.slug'))
                                        ->afterLabel(__('cms::pages.helpers.slug'))
                                        ->required()
                                        ->unique(ignorable: fn($record) => $record),

                                    TextInput::make('name')
                                        ->label(__('cms::products.name'))
                                        ->required()
                                        ->suffixAction(static::lkSyncAction('name')),
                                ]),

                                RichEditor::make('summary')
                                    ->label(__('cms::products.summary'))
                                    ->columnSpanFull()
                                    ->hintAction(self::lkSyncAction('summary')),

                                RichEditor::make('description')
                                    ->label(__('cms::products.description'))
                                    ->columnSpanFull()
                                    ->hintAction(self::lkSyncAction('description')),

                                SpatieMediaLibraryFileUpload::make('images')
                                    ->label(__('cms::products.images'))
                                    ->collection('product')
                                    ->disk('public')
                                    ->multiple()
                                    ->image()
                                    ->imageEditor()
                                    ->reorderable()
                                    ->panelLayout('grid')
                                    ->getUploadedFileNameForStorageUsing(
                                        // UUID-based, unique file name with original title + hash and extension
                                        fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                                            . '_' . Str::uuid()
                                            . '.' . $file->getClientOriginalExtension()
                                    )
                                    ->appendFiles(),

                                // ── Optionele velden ──────────────────────────
                                Fieldset::make(__('cms::products.optional_fields'))
                                    ->schema([
                                        TextInput::make('location')
                                            ->label(__('cms::products.location'))
                                            ->prefixIcon(Heroicon::MapPin)
                                            ->columnSpanFull()
                                            ->suffixAction(static::lkSyncAction('location')),

                                        TextInput::make('min_persons')
                                            ->minValue(0)
                                            ->label(__('cms::products.min_persons'))
                                            ->numeric()
                                            ->suffixAction(static::lkSyncAction('min_persons')),

                                        TextInput::make('max_persons')
                                            ->minValue(1)
                                            ->label(__('cms::products.max_persons'))
                                            ->numeric()
                                            ->suffixAction(static::lkSyncAction('max_persons')),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                // ── Pagina instellingen ───────────────────────
                                Fieldset::make(__('cms::products.page_settings'))
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label(__('cms::products.is_active'))
                                            ->inline(false)
                                            ->default(true),

                                        // Clickable URL to the page
                                        TextEntry::make('url')
                                            ->hiddenOn('create')
                                            ->label(__('cms::products.view'))
                                            ->state(__('cms::common.click_here'))
                                            ->url(
                                                fn($record) => config('cms.routes.product') ?
                                                    route(config('cms.routes.product'), $record->slug) :
                                                    null
                                            )
                                            ->hidden(fn(Get $get) => !$get('is_active') || !config('cms.routes.product'))
                                            ->icon(Heroicon::Link)
                                            ->openUrlInNewTab()
                                            ->color('primary'),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                // ── Audit info ────────────────────────────────
                                Grid::make(2)
                                    ->hiddenOn('create')
                                    ->schema([
                                        TextEntry::make('created_at')
                                            ->label(__('cms::common.created_at'))
                                            ->dateTime('d-m-Y H:i')
                                            ->color('gray'),

                                        TextEntry::make('updated_at')
                                            ->label(__('cms::common.updated_at'))
                                            ->dateTime('d-m-Y H:i')
                                            ->color('gray'),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ─── 2. PRIJZEN & BOEKEN ─────────────────────────────
                        Tabs\Tab::make(__('cms::products.tabs.prices'))
                            ->schema([
                                Section::make(__('cms::products.prices.heading'))
                                    ->aside()
                                    ->description(__('cms::products.prices.description'))
                                    ->schema([
                                        Repeater::make('prices')
                                            ->label(__('cms::products.prices.label'))
                                            ->relationship('prices')
                                            ->addActionLabel(__('cms::products.prices.add_label'))
                                            ->collapsed()
                                            ->itemLabel(fn(array $state): ?string => trim(($state['label'] ?? __('cms::products.prices.amount')) . ' – ' . ($state['amount'] ?? '')))
                                            ->hintAction(self::lkSyncAction('prices'))
                                            ->grid()
                                            ->minItems(1)
                                            ->rule(
                                                fn() => function (string $attribute, mixed $value, Closure $fail) {
                                                    $euroId = Currency::where('code', 'EUR')->value('id');
                                                    $hasEuro = collect($value)->contains('currency_id', $euroId);
                                                    if (!$hasEuro) {
                                                        $fail(__('cms::products.prices.euro_required'));
                                                    }
                                                }
                                            )
                                            ->schema([
                                                Select::make('currency_id')
                                                    ->label(__('cms::products.prices.currency'))
                                                    ->options(Currency::all()->pluck('name', 'id'))
                                                    ->required()
                                                    ->live(),

                                                TextInput::make('amount')
                                                    ->label(__('cms::products.prices.amount'))
                                                    ->inputMode('decimal')
                                                    ->step(0.01)
                                                    ->required()
                                                    ->live()
                                                    ->mask(RawJs::make('$money($input, \',\')'))
                                                    ->formatStateUsing(
                                                        fn($state) => $state
                                                            ? number_format((float)$state, 2, ',', '.')
                                                            : null
                                                    )
                                                    ->dehydrateStateUsing(
                                                        fn($state) => $state
                                                            ? (float)str_replace(',', '.', str_replace('.', '', $state))
                                                            : null
                                                    )
                                                    ->prefix(
                                                        fn($get) => Currency::find($get('currency_id'))?->symbol ?? '?'
                                                    ),

                                                Toggle::make('includes_vat')
                                                    ->label(__('cms::products.prices.includes_vat'))
                                                    ->default(true),

                                                TextInput::make('label')
                                                    ->label(__('cms::products.prices.price_label'))
                                                    ->belowContent(__('cms::products.prices.helpers.price_label')),

                                                Fieldset::make(__('cms::products.prices.time_block'))
                                                    ->schema([
                                                        TimePicker::make('from_time')->label(__('cms::common.time_schemes.start_time')),
                                                        TimePicker::make('to_time')->label(__('cms::common.time_schemes.end_time')),
                                                    ])
                                                    ->columns(2)
                                                    ->columnSpanFull(),
                                            ])
                                            ->reorderable()
                                            ->orderColumn('sort_order'),
                                    ])
                                    ->columnSpanFull(),

                                Section::make(__('cms::products.book_option.heading'))
                                    ->aside()
                                    ->description(__('cms::products.book_option.description'))
                                    ->schema([
                                        ToggleButtons::make('book_option')
                                            ->label(__('cms::products.book_option.label'))
                                            ->inline()
                                            ->live()
                                            ->required()
                                            ->options([
                                                'book_now' => __('cms::products.book_option.options.book_now'),
                                                'quotation' => __('cms::products.book_option.options.quotation'),
                                                'forward' => __('cms::products.book_option.options.forward'),
                                            ])
                                            ->default('book_now'),

                                        TextInput::make('forward_url')
                                            ->label(__('cms::products.book_option.forward_url'))
                                            ->required()
                                            ->url()
                                            ->hidden(fn(Get $get) => $get('book_option') !== 'forward'),

                                        TextInput::make('forward_title')
                                            ->label(__('cms::products.book_option.forward_title'))
                                            ->placeholder(__('cms::products.book_option.forward_title_placeholder'))
                                            ->required()
                                            ->hidden(fn(Get $get) => $get('book_option') !== 'forward'),

                                        TextInput::make('forward_description')
                                            ->label(__('cms::products.book_option.forward_description'))
                                            ->placeholder(__('cms::products.book_option.forward_description_placeholder'))
                                            ->required()
                                            ->hidden(fn(Get $get) => $get('book_option') !== 'forward'),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ─── 3. SEO ──────────────────────────────────────────
                        Tabs\Tab::make(__('cms::products.tabs.seo'))
                            ->schema([
                                Section::make(__('cms::seo.title'))
                                    ->description(__('cms::seo.description'))
                                    ->aside()
                                    ->schema([
                                        SeoSettings::make('product/og'),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ─── 4. FAQ ──────────────────────────────────────────
                        Tabs\Tab::make(__('cms::products.tabs.faq'))
                            ->schema([
                                Section::make(__('cms::products.faqs.heading'))
                                    ->aside()
                                    ->description(__('cms::products.faqs.description'))
                                    ->schema([
                                        Repeater::make('faqs')
                                            ->label(__('cms::products.faqs.label'))
                                            ->addActionLabel(__('cms::products.faqs.add_label'))
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['question'] ?? null)
                                            ->schema([
                                                TextInput::make('question')
                                                    ->label(__('cms::products.faqs.question'))
                                                    ->required(),
                                                RichEditor::make('answer')
                                                    ->label(__('cms::products.faqs.answer'))
                                                    ->required(),
                                            ])
                                            ->default([]),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ─── 5. PAKKET & INTEGRATIE ──────────────────────────
                        Tabs\Tab::make(__('cms::products.tabs.package'))
                            ->schema([
                                Section::make(__('cms::products.package.heading'))
                                    ->collapsed()
                                    ->aside()
                                    ->description(__('cms::products.package.description'))
                                    ->schema([
                                        Toggle::make('is_package')
                                            ->label(__('cms::products.package.is_package'))
                                            ->reactive(),

                                        Repeater::make('time_schemes')
                                            ->label(__('cms::products.package.time_schemes'))
                                            ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                            ->hidden(fn(Get $get) => !$get('is_package'))
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label(__('cms::common.time_schemes.name'))
                                                    ->placeholder(__('cms::common.time_schemes.name_placeholder'))
                                                    ->required(),

                                                Repeater::make('rows')
                                                    ->label(__('cms::common.time_schemes.rows'))
                                                    ->grid(2)
                                                    ->schema([
                                                        Grid::make(2)->schema([
                                                            TimePicker::make('start_time')
                                                                ->label(__('cms::common.time_schemes.start_time'))
                                                                ->required(),
                                                            TimePicker::make('end_time')
                                                                ->label(__('cms::common.time_schemes.end_time'))
                                                                ->required(),
                                                        ]),
                                                        TextInput::make('activity')
                                                            ->label(__('cms::common.time_schemes.activity'))
                                                            ->placeholder(__('cms::common.time_schemes.activity_placeholder'))
                                                            ->required(),
                                                    ])
                                                    ->addActionLabel(__('cms::common.time_schemes.add_row')),
                                            ])
                                            ->addActionLabel(__('cms::common.time_schemes.add_label')),
                                    ])
                                    ->columnSpanFull(),

                                Section::make(__('cms::products.leisureking.heading'))
                                    ->aside()
                                    ->description(__('cms::products.leisureking.description'))
                                    ->schema([
                                        Select::make('leisureking_id')
                                            ->label(__('cms::products.leisureking.id'))
                                            ->searchable()
                                            ->live()
                                            ->options(function () {
                                                $assortment = self::lkApi()->request('/assortment/get');
                                                return collect($assortment)
                                                    ->mapWithKeys(fn($row) => [
                                                        $row['id_assortment'] => $row['display_name'] . ' (' . $row['id_assortment'] . ')'
                                                    ])
                                                    ->toArray();
                                            })
                                            ->suffixAction(self::executeLkSyncAction()),

                                        TextInput::make('leisureking_bookingmodule_hash')
                                            ->label(__('cms::products.leisureking.bookingmodule_hash'))
                                            ->afterLabel(__('cms::products.leisureking.helpers.bookingmodule_hash'))
                                            ->requiredIf('book_option', 'book_now'),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                    ])->columnSpanFull(),
            ]);
    }
}
