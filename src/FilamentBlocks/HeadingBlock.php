<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

class HeadingBlock
{
    public static function make(): Block
    {
        return Block::make('heading-block')
            ->label(__('cms::blocks.heading-block.label'))
            ->icon(Heroicon::H1)
            ->schema([
                TextInput::make('content')
                    ->label(__('cms::blocks.heading-block.content'))
                    ->required(),
                Select::make('level')
                    ->label(__('cms::blocks.heading-block.level'))
                    ->options([
                        'h1' => __('cms::blocks.heading-block.levels.h1'),
                        'h2' => __('cms::blocks.heading-block.levels.h2'),
                        'h3' => __('cms::blocks.heading-block.levels.h3'),
                        'h4' => __('cms::blocks.heading-block.levels.h4'),
                        'h5' => __('cms::blocks.heading-block.levels.h5'),
                        'h6' => __('cms::blocks.heading-block.levels.h6'),
                    ])
                    ->required(),
            ])
            ->columns(2);
    }
}
