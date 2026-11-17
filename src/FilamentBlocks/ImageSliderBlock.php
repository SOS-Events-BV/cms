<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageSliderBlock
{
    /**
     * Creates the configuration for an image slider block.
     *
     * @param string $directory The directory where images will be stored. Defaults to 'page/slider'.
     * @return Block The configured image slider block instance.
     */
    public static function make(string $directory = 'page/slider'): Block
    {
        return Block::make('image-slider-block')
            ->label(__('cms::blocks.image-slider-block.label'))
            ->icon(Heroicon::Photo)
            ->schema([
                Repeater::make('images')
                    ->label(__('cms::blocks.image-slider-block.images'))
                    ->schema([
                        FileUpload::make('url')
                            ->label(__('cms::blocks.image-slider-block.image'))
                            ->disk('public')
                            ->directory($directory . '/slider')
                            ->image()
                            ->imageEditor()
                            ->getUploadedFileNameForStorageUsing(
                                // UUID-based, unique file name with original title + hash and extension
                                fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                                    . '_' . Str::uuid()
                                    . '.' . $file->getClientOriginalExtension()
                            )
                            ->required(),

                        TextInput::make('alt')
                            ->label(__('cms::blocks.image-slider-block.alt')),
                    ])
                    ->grid(2)
                    ->addActionLabel(__('cms::blocks.image-slider-block.add_label')),

                Section::make(__('cms::blocks.image-slider-block.settings'))
                    ->collapsed()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Toggle::make('loop')
                                    ->label(__('cms::blocks.image-slider-block.loop'))
                                    ->default(false),

                                Toggle::make('navigation')
                                    ->label(__('cms::blocks.image-slider-block.navigation'))
                                    ->default(false),

                                Toggle::make('pagination')
                                    ->label(__('cms::blocks.image-slider-block.pagination'))
                                    ->default(false),

                                Toggle::make('autoplay')
                                    ->label(__('cms::blocks.image-slider-block.autoplay'))
                                    ->default(false)
                                    ->live(),
                            ]),

                        TextInput::make('autoplay_speed')
                            ->label(__('cms::blocks.image-slider-block.autoplay_speed'))
                            ->numeric()
                            ->default(3000)
                            ->minValue(500)
                            ->suffix('ms')
                            ->visible(fn($get) => $get('autoplay')),

                        Section::make(__('cms::blocks.image-slider-block.slides_per_breakpoint'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('slides_mobile')
                                            ->label(__('cms::blocks.image-slider-block.slides_mobile'))
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1),
                                        TextInput::make('slides_tablet')
                                            ->label(__('cms::blocks.image-slider-block.slides_tablet'))
                                            ->numeric()
                                            ->default(2)
                                            ->minValue(1),
                                        TextInput::make('slides_desktop')
                                            ->label(__('cms::blocks.image-slider-block.slides_desktop'))
                                            ->numeric()
                                            ->default(3)
                                            ->minValue(1),
                                    ]),
                            ]),

                        TextInput::make('space_between')
                            ->label(__('cms::blocks.image-slider-block.space_between'))
                            ->suffix('px')
                            ->numeric()
                            ->default(20),
                    ]),
            ]);
    }
}
