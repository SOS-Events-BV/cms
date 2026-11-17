<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

class SpacerBlock
{
    public static function make(): Block
    {
        return Block::make('spacer-block')
            ->label('Witruimte')
            ->icon(Heroicon::ArrowsUpDown)
            ->schema([
                TextInput::make('px')->numeric()->suffix('px')->label('Hoogte'),
            ]);
    }
}
