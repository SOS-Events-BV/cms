<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Support\Icons\Heroicon;

class VideoBlock
{
    public static function make(): Block
    {
        return Block::make('video-block')
            ->label(__('cms::blocks.video-block.label'))
            ->icon(Heroicon::VideoCamera)
            ->schema([
                TextInput::make('video_id')
                    ->label(__('cms::blocks.video-block.video_id'))
                    ->afterLabel(__('cms::blocks.video-block.helpers.video_id')),

                Flex::make([
                    Toggle::make('autoplay')
                        ->label(__('cms::blocks.video-block.autoplay'))
                        ->helperText(__('cms::blocks.video-block.helpers.autoplay'))
                        ->default(false),

                    Toggle::make('controls')
                        ->label(__('cms::blocks.video-block.controls'))
                        ->helperText(__('cms::blocks.video-block.helpers.controls'))
                        ->default(true),

                    Toggle::make('mute')
                        ->label(__('cms::blocks.video-block.mute'))
                        ->helperText(__('cms::blocks.video-block.helpers.mute'))
                        ->default(false),
                ])
            ]);
    }
}
