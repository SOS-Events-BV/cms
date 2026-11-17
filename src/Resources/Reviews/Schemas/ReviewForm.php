<?php

namespace SOSEventsBV\Cms\Resources\Reviews\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('cms::reviews.info.heading'))
                    ->description(__('cms::reviews.info.description'))
                    ->columnSpanFull()
                    ->aside()
                    ->columns(2)
                    ->schema([
                        // When the user placed the review
                        TextEntry::make('review_placed')
                            ->label(__('cms::reviews.review_placed'))
                            ->icon(Heroicon::Clock)
                            ->dateTime(),

                        // When the review was placed on the website
                        TextEntry::make('created_at')
                            ->label(__('cms::reviews.created_at'))
                            ->icon(Heroicon::Plus)
                            ->dateTime(),

                        TextEntry::make('stars')
                            ->label(__('cms::reviews.stars'))
                            ->icon(Heroicon::Star),

                        Toggle::make('is_visible')
                            ->label(__('cms::reviews.is_visible'))
                            ->inline(false),

                        // Link to LeisureKing reservation
                        TextEntry::make('reservation_hash')
                            ->icon(Heroicon::Link)
                            ->color('primary')
                            ->url(fn($record) => "https://oms.leisureking.eu/reservering?h={$record->reservation_hash}") // URL that will be opened
                            ->openUrlInNewTab()
                            ->label(__('cms::reviews.reservation_hash')),

                        // Extra attributes field in the table
                        KeyValueEntry::make('extra_attributes')
                            ->label(__('cms::reviews.extra_attributes')),
                    ]),

                TextInput::make('firstname')->label(__('cms::reviews.firstname')),
                TextInput::make('lastname')->label(__('cms::reviews.lastname')),
                Textarea::make('review')->autosize()->label(__('cms::reviews.review')),
                Textarea::make('reaction')->autosize()->label(__('cms::reviews.reaction')),
            ]);
    }
}
