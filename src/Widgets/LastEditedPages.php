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
    protected static ?string $heading = "Laatst gewijzigde pagina's";

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Page::query()->latest('updated_at')->limit(5))
            ->paginated(false)
            ->recordUrl(fn(Page $record): string => PageResource::getUrl('edit', ['record' => $record]))
            ->columns([
                TextColumn::make('seo.page_title')
                    ->label('Titel'),

                TextColumn::make('slug')
                    ->label('Pagina')
                    ->url(fn($record) => config('cms.routes.page') && $record->is_active ? route(config('cms.routes.page'), $record->slug) : null)
                    ->icon(config('cms.routes.page') ? Heroicon::Link : null)
                    ->color(fn($record) => config('cms.routes.page') && $record->is_active ? 'primary' : 'gray')
                    ->openUrlInNewTab(),

                ToggleColumn::make('is_active')
                    ->label('Actief'),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn(Page $record): string => PageResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
