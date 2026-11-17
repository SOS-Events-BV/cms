<?php

namespace SOSEventsBV\Cms\Resources\Events;

use SOSEventsBV\Cms\Enums\NavigationGroup;
use Override;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use SOSEventsBV\Cms\Models\Event;
use SOSEventsBV\Cms\Resources\Events\Pages\CreateEvent;
use SOSEventsBV\Cms\Resources\Events\Pages\EditEvent;
use SOSEventsBV\Cms\Resources\Events\Pages\ListEvents;
use SOSEventsBV\Cms\Resources\Events\Schemas\EventForm;
use SOSEventsBV\Cms\Resources\Events\Tables\EventsTable;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Pages;

    #[Override]
    public static function getModelLabel(): string
    {
        return __('cms::events.event');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('cms::events.events');
    }

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
