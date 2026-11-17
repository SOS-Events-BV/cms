<?php

namespace SOSEventsBV\Cms\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use SOSEventsBV\Cms\CmsPlugin;
use SOSEventsBV\Cms\FilamentComponents\SeoSettings;
use SOSEventsBV\Cms\FilamentComponents\ContentBuilder;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('cms::seo.title'))
                    ->description(__('cms::seo.description'))
                    ->aside()
                    ->schema([
                        // SEO Settings component
                        SeoSettings::make('page/og'),

                        Grid::make(2)->schema([
                            TextEntry::make('url')
                                ->hiddenOn('create')
                                ->label(__('cms::common.view'))
                                ->state(__('cms::common.click_here'))
                                ->url(fn(Get $get, $record) => $get('is_active') && config('cms.routes.page') ? route(config('cms.routes.page'), $record->slug) : null)
                                ->icon(Heroicon::Link)
                                ->color(fn(Get $get) => $get('is_active') ? 'primary' : 'gray')
                                ->openUrlInNewTab(),

                            // Toggle for active status
                            Toggle::make('is_active')
                                ->label(__('cms::common.active'))
                                ->inline(false)
                                ->default(true)
                                ->live(),
                        ]),

                        // Created by and updated by with timestamps
                        Grid::make(2)->hiddenOn('create')->schema([
                            TextEntry::make('created_at')
                                ->label(__('cms::common.created_at'))
                                ->dateTime('d-m-Y H:i')
                                ->color('gray'),

                            TextEntry::make('updated_at')
                                ->label(__('cms::common.updated_at'))
                                ->dateTime('d-m-Y H:i')
                                ->color('gray'),
                        ]),
                    ])->columnSpanFull(),

                // Unique slug to the page
                TextInput::make('slug')
                    ->label(__('cms::pages.slug'))
                    ->afterLabel(__('cms::pages.helpers.slug'))
                    ->required()
                    ->unique(ignorable: fn($record) => $record)
                    ->helperText(
                        fn($record, Get $get) => $get('slug') ?
                            __('cms::pages.helpers.url', ['url' => route(config('cms.routes.page'), $get('slug'))])
                            : null
                    )
                    ->live(debounce: 500)
                    ->columnSpanFull(),

                // Page Builder
                ContentBuilder::make('content'),

                Section::make(__('cms::pages.additional_fields'))
                    ->columns(2)
                    ->schema(CmsPlugin::get()->getAdditionalPageInputs())
                    ->columnSpanFull()
                    ->hidden(empty(CmsPlugin::get()->getAdditionalPageInputs())),
            ]);
    }
}
