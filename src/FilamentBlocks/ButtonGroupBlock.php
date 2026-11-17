<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\Icons\Heroicon;

class ButtonGroupBlock
{
    public static function make(): Block
    {
        return Block::make('button-group-block')
            ->label(__('cms::blocks.button-group-block.label'))
            ->icon(Heroicon::CursorArrowRays)
            ->schema([
                Repeater::make('buttons')
                    ->hiddenLabel()
                    ->schema([
                        // Add different types of buttons here
                        // 3 defaults are added in the template by default. If you have another button here, add this one to this file.
                        Select::make('class')
                            ->label(__('cms::blocks.button-group-block.type'))
                            ->options(config('cms.buttons'))->required(),

                        TextInput::make('content')
                            ->label(__('cms::blocks.button-group-block.content'))
                            ->required(),

                        TextInput::make('url')
                            ->label(__('cms::blocks.button-group-block.url'))
                            ->required(),

                        Toggle::make('open_in_new_tab')
                            ->label(__('cms::blocks.button-group-block.open_in_new_tab'))
                            ->required()
                            ->inline(false),
                    ])->columns(2)
            ]);
    }
}
