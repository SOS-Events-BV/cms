<?php

namespace SOSEventsBV\Cms\Resources\Reviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label(__('cms::reviews.full_name'))
                    ->searchable(['firstname', 'lastname']),

                TextColumn::make('stars')
                    ->label(__('cms::reviews.stars'))
                    ->sortable(),

                TextColumn::make('review')
                    ->label(__('cms::reviews.review'))
                    ->limit(30),

                IconColumn::make('reaction')
                    ->label(__('cms::reviews.has_reaction'))
                    ->boolean()
                    ->state(fn($record): bool => !empty($record->reaction)),

                ToggleColumn::make('is_visible')
                    ->label(__('cms::reviews.is_visible')),

                TextColumn::make('review_placed')
                    ->label(__('cms::reviews.review_placed'))
                    ->sortable()
                    ->dateTime(),
            ])
            ->defaultSort('review_placed', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                ]),
            ]);
    }
}
