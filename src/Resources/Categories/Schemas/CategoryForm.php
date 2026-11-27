<?php

namespace SOSEventsBV\Cms\Resources\Categories\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use SOSEventsBV\Cms\FilamentComponents\SeoSettings;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('cms::seo.title'))
                    ->description(__('cms::seo.description'))
                    ->aside()
                    ->schema([
                        SeoSettings::make('category/og'),

                        Grid::make(2)->schema([
                            TextEntry::make('url')
                                ->hiddenOn('create')
                                ->label(__('cms::common.view'))
                                ->state(__('cms::common.click_here'))
                                ->url(fn(Get $get, $record) => $get('is_active') && config('cms.routes.category') ? route(config('cms.routes.category'), $record->slug) : null)
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

                TextInput::make('name')
                    ->label(__('cms::common.name'))
                    ->required(),

                TextInput::make('slug')
                    ->label(__('cms::common.slug'))
                    ->unique(ignorable: fn($record) => $record)
                    ->required(),

                RichEditor::make('description')
                    ->label(__('cms::common.description'))
                    ->required()
                    ->columnSpanFull(),

                Select::make('products')
                    ->label(__('cms::categories.products'))
                    ->helperText(__('cms::categories.helpers.products'))
                    ->relationship('products', 'name')
                    ->multiple()
                    ->preload(),

                Repeater::make('example_time_schemes')
                    ->label(__('cms::categories.example_time_schemes'))
                    ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
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
                    ->columnSpanFull()
                    ->addActionLabel(__('cms::common.time_schemes.add_label')),

                SpatieMediaLibraryFileUpload::make('images')
                    ->label(__('cms::categories.images'))
                    ->collection('category')
                    ->disk('public')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->reorderable()
                    ->appendFiles()
                    ->panelLayout('grid')
                    ->getUploadedFileNameForStorageUsing(
                        // UUID-based, unique file name with original title + hash and extension
                        fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                            . '_' . Str::uuid()
                            . '.' . $file->getClientOriginalExtension()
                    )
                    ->columnSpanFull(),
            ]);
    }
}
