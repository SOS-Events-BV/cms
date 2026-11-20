<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class LeisurekingBlock
{
    public static function make(): Block
    {
        return Block::make('leisureking-block')
            ->label(__('cms::blocks.leisureking-block.label'))
            ->icon(Heroicon::ComputerDesktop)
            ->schema([
                TextInput::make('bookingmodule_code')
                    ->prefix('https://booking.leisureking.eu/bm/')
                    ->label(__('cms::blocks.leisureking-block.bookingmodule_code'))
                    ->required()
                    ->maxLength(255),

                Section::make(__('cms::blocks.leisureking-block.settings'))
                    ->collapsible()
                    ->columns(3)
                    ->schema([
                        Toggle::make('no_scroll')
                            ->label(__('cms::blocks.leisureking-block.no_scroll'))
                            ->inline(false)
                            ->default(true)
                            ->helperText(__('cms::blocks.leisureking-block.helpers.no_scroll')),

                        DatePicker::make('date')
                            ->label(__('cms::blocks.leisureking-block.date'))
                            ->helperText(__('cms::blocks.leisureking-block.helpers.date'))
                            ->default(null),

                        DatePicker::make('min_date')
                            ->label(__('cms::blocks.leisureking-block.min_date'))
                            ->helperText(__('cms::blocks.leisureking-block.helpers.min_date'))
                            ->default(null),

                        DatePicker::make('max_date')
                            ->label(__('cms::blocks.leisureking-block.max_date'))
                            ->helperText(__('cms::blocks.leisureking-block.helpers.max_date'))
                            ->default(null),

                        Select::make('lang')
                            ->label(__('cms::blocks.leisureking-block.lang'))
                            ->helperText(__('cms::blocks.leisureking-block.helpers.lang'))
                            ->options([
                                'NL' => __('cms::blocks.leisureking-block.languages.NL'),
                                'EN' => __('cms::blocks.leisureking-block.languages.EN'),
                                'DE' => __('cms::blocks.leisureking-block.languages.DE'),
                                'FR' => __('cms::blocks.leisureking-block.languages.FR'),
                                'ES' => __('cms::blocks.leisureking-block.languages.ES'),
                                'PT' => __('cms::blocks.leisureking-block.languages.PT'),
                            ])
                            ->default(null),
                    ])
            ]);
    }
}
