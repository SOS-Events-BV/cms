<?php

namespace SOSEventsBV\Cms\Widgets;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use SOSEventsBV\Cms\Models\Page;
use SOSEventsBV\Cms\Resources\Pages\PageResource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ToggleColumn;

class LastEditedPages extends TableWidget
{
    protected int|string|array $columnSpan = "full";

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('cms::pages.widget.heading'))
            ->query(fn(): Builder => Page::query()->latest('updated_at')->limit(5))
            ->paginated(false)
            ->recordUrl(fn(Page $record): string => PageResource::getUrl('edit', ['record' => $record]))
            ->columns([
                TextColumn::make('seo.page_title')
                    ->label(__('cms::common.title')),

                TextColumn::make('slug')
                    ->label(__('cms::pages.page'))
                    ->url(fn($record) => config('cms.routes.page') && $record->is_active ? route(config('cms.routes.page'), $record->slug) : null)
                    ->icon(config('cms.routes.page') ? Heroicon::Link : null)
                    ->color(fn($record) => config('cms.routes.page') && $record->is_active ? 'primary' : 'gray')
                    ->openUrlInNewTab(),

                ToggleColumn::make('is_active')
                    ->label(__('cms::common.active')),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn(Page $record): string => PageResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
