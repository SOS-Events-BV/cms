<?php

namespace SOSEventsBV\Cms\Resources\Redirects;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Override;
use SOSEventsBV\Cms\Enums\NavigationGroup;
use SOSEventsBV\Cms\Models\Redirect;
use SOSEventsBV\Cms\Resources\Redirects\Pages\ManageRedirects;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowsRightLeft;

    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    #[Override]
    public static function getModelLabel(): string
    {
        return __('cms::redirects.redirect');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('cms::redirects.redirects');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('language')
                    ->label(__('cms::redirects.language'))
                    ->options(fn (): array => collect(config('cms.services.weglot.available_languages', []))
                        ->mapWithKeys(fn (string $language): array => [$language => strtoupper($language)])
                        ->all())
                    ->placeholder(__('cms::redirects.all_languages'))
                    ->helperText(__('cms::redirects.helpers.language'))
                    ->native(false)
                    ->columnSpanFull(),

                TextInput::make('from')
                    ->label(__('cms::redirects.from'))
                    ->required()
                    ->prefix(config('app.url').'/')
                    ->placeholder(__('cms::redirects.placeholders.from'))
                    ->helperText(__('cms::redirects.helpers.from'))
                    ->dehydrateStateUsing(fn ($state) => ltrim($state, '/')) // Removes slash if the user types it
                    ->columnSpanFull(),

                TextInput::make('to')
                    ->label(__('cms::redirects.to'))
                    ->required()
                    ->placeholder(__('cms::redirects.placeholders.to'))
                    ->helperText(__('cms::redirects.helpers.to'))
                    ->dehydrateStateUsing(function ($state) {
                        if (empty($state)) {
                            return $state;
                        }

                        // If the user types in a full URL, just return it.
                        if (str_starts_with($state, 'http')) {
                            return $state;
                        }

                        // If the user types in a relative URL, add a / to the beginning.
                        return str_starts_with($state, '/') ? $state : "/{$state}";
                    })
                    ->columnSpanFull(),

                Select::make('status_code')
                    ->label(__('cms::redirects.status_code'))
                    ->options([
                        301 => __('cms::redirects.status_codes.301'),
                        302 => __('cms::redirects.status_codes.302'),
                    ])
                    ->default(301)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('language')
                    ->label(__('cms::redirects.language'))
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->placeholder(__('cms::redirects.all_languages')),

                TextColumn::make('from')
                    ->label(__('cms::redirects.from'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('to')
                    ->label(__('cms::redirects.to'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status_code')
                    ->label(__('cms::redirects.status_code'))
                    ->colors([
                        'success' => 301,
                        'warning' => 302,
                    ])
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status_code')
                    ->label(__('cms::redirects.status_code'))
                    ->options([
                        301 => __('cms::redirects.status_codes.301'),
                        302 => __('cms::redirects.status_codes.302'),
                    ])
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRedirects::route('/'),
        ];
    }
}
