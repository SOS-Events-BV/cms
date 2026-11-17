<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;
use Filament\Support\Icons\Heroicon;

class ReadMoreBlock
{
    public static function make(): Block
    {
        return Block::make('read-more-block')
            ->label(__('cms::blocks.read-more-block.label'))
            ->icon(Heroicon::BookOpen)
            ->schema([
                RichEditor::make('content_1')
                    ->label(__('cms::blocks.read-more-block.content_1'))
                    ->helperText(__('cms::blocks.read-more-block.helpers.content_1')),

                RichEditor::make('content_2')
                    ->label(__('cms::blocks.read-more-block.content_2'))
                    ->helperText(__('cms::blocks.read-more-block.helpers.content_2')),
            ]);
    }
}
