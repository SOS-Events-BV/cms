<?php

namespace SOSEventsBV\Cms\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('cms::common.name'))
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label(__('cms::events.start_date'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('cms::events.end_date'))
                    ->dateTime()
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label(__('cms::common.active')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
