<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use SOSEventsBV\Cms\FilamentComponents\ContentBuilder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Support\Icons\Heroicon;

class TwoColumnBlock
{
    public static function make(string $directory = 'page'): Block
    {
        return Block::make('two-column-block')
            ->label(__('cms::blocks.two-column-block.label'))
            ->icon(Heroicon::ViewColumns)
            ->columns(2)
            ->schema([
                Group::make()
                    ->columns(3)
                    ->schema([
                        Select::make('layout_ratio')
                            ->label(__('cms::blocks.two-column-block.layout_ratio'))
                            ->helperText(__('cms::blocks.two-column-block.helpers.layout_ratio'))
                            ->options([
                                '50_50' => __('cms::blocks.two-column-block.ratios.50_50'),
                                '33_66' => __('cms::blocks.two-column-block.ratios.33_66'),
                                '66_33' => __('cms::blocks.two-column-block.ratios.66_33'),
                                '25_75' => __('cms::blocks.two-column-block.ratios.25_75'),
                                '75_25' => __('cms::blocks.two-column-block.ratios.75_25'),
                            ])
                            ->default('50_50'),

                        ColorPicker::make('background_color')
                            ->label(__('cms::blocks.two-column-block.background_color'))
                            ->helperText(__('cms::blocks.two-column-block.helpers.background_color'))
                            ->nullable(),

                        ColorPicker::make('text_color')
                            ->label(__('cms::blocks.two-column-block.text_color'))
                            ->helperText(__('cms::blocks.two-column-block.helpers.text_color'))
                            ->nullable(),

                        Toggle::make('center_content')
                            ->inline(false)
                            ->default(false)
                            ->label(__('cms::blocks.two-column-block.center_content'))
                            ->helperText(__('cms::blocks.two-column-block.helpers.center_content')),
                    ])->columnSpanFull(),


                Builder::make('left_column')
                    ->label(__('cms::blocks.two-column-block.left_column'))
                    ->blocks(ContentBuilder::columnBlocks($directory))
                    ->blockIcons()
                    ->blockPickerColumns(2)
                    ->reorderableWithButtons(),

                Builder::make('right_column')
                    ->label(__('cms::blocks.two-column-block.right_column'))
                    ->blocks(ContentBuilder::columnBlocks($directory))
                    ->blockIcons()
                    ->blockPickerColumns(2)
                    ->reorderableWithButtons(),
            ]);
    }
}
