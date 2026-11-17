<?php

namespace SOSEventsBV\Cms\Resources\Pages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('seo.page_title')
                    ->label(__('cms::common.title'))
                    ->searchable(),

                TextColumn::make('slug')
                    ->label(__('cms::pages.slug'))
                    ->searchable()
                    ->url(fn($record) => config('cms.routes.page') && $record->is_active ? route(config('cms.routes.page'), $record->slug) : null)
                    ->icon(config('cms.routes.page') ? Heroicon::Link : null)
                    ->color(fn($record) => config('cms.routes.page') && $record->is_active ? 'primary' : 'gray')
                    ->openUrlInNewTab(),

                ToggleColumn::make('is_active')
                    ->label(__('cms::common.active')),

                TextColumn::make('created_at')->dateTime()->label(__('cms::common.created_at'))->sortable(),
            ])
            ->filters([
                // Filter for only active pages
                Filter::make('is_active')->label(__('cms::pages.filters.only_active_pages'))->query(function (Builder $query) {
                    return $query->where('is_active', true);
                })->toggle()
            ])
            ->recordActions([
                EditAction::make(),

                // Add a DeleteAction with a custom modal heading and description
                DeleteAction::make()
                    ->modalHeading(__('cms::pages.delete_modal.heading'))
                    ->modalDescription(__('cms::pages.delete_modal.description'))
                    ->successNotification(
                        Notification::make()
                            ->warning()
                            ->title(__('cms::pages.delete_modal.notification.title'))
                            ->body(__('cms::redirects.reminder.body'))
                            ->persistent()
                            ->actions([
                                Action::make('createRedirect')
                                    ->label(__('cms::redirects.reminder.button'))
                                    ->button()
                                    ->url(route('filament.admin.resources.redirects.index'))
                            ])
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                ]),
            ]);
    }
}
