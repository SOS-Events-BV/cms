<?php

namespace SOSEventsBV\Cms\Resources\Announcements;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Override;
use SOSEventsBV\Cms\Enums\AnnouncementType;
use SOSEventsBV\Cms\Enums\NavigationGroup;
use SOSEventsBV\Cms\Models\Announcement;
use SOSEventsBV\Cms\Resources\Announcements\Pages\ManageAnnouncements;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBellAlert;

    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Pages;

    protected static ?string $recordTitleAttribute = 'title';

    #[Override]
    public static function getModelLabel(): string
    {
        return __('cms::announcements.announcement');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('cms::announcements.announcements');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label(__('cms::announcements.type'))
                    ->options(AnnouncementType::class)
                    ->native(false)
                    ->required(),

                TextInput::make('title')
                    ->label(__('cms::common.title'))
                    ->required(),

                RichEditor::make('message')
                    ->label(__('cms::announcements.message'))
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'link'],
                        ['undo', 'redo'],
                    ])
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('button_text')
                    ->label(__('cms::announcements.button_text'))
                    ->placeholder(__('cms::announcements.placeholders.button_text'))
                    ->helperText(__('cms::announcements.helpers.button'))
                    ->default(null),

                TextInput::make('button_url')
                    ->label(__('cms::announcements.button_url'))
                    ->placeholder(__('cms::announcements.placeholders.button_url'))
                    ->url()
                    ->default(null),

                DatePicker::make('starts_at')
                    ->label(__('cms::announcements.starts_at'))
                    ->helperText(__('cms::announcements.helpers.dates'))
                    ->required(),

                DatePicker::make('ends_at')
                    ->label(__('cms::announcements.ends_at'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('type')
                    ->label(__('cms::announcements.type'))
                    ->badge()
                    ->searchable(),

                TextColumn::make('title')
                    ->label(__('cms::common.title'))
                    ->searchable(),

                TextColumn::make('button_text')
                    ->label(__('cms::announcements.button_text'))
                    ->searchable(),

                TextColumn::make('button_url')
                    ->label(__('cms::announcements.button_url'))
                    ->searchable(),

                TextColumn::make('starts_at')
                    ->label(__('cms::announcements.starts_at'))
                    ->date()
                    ->sortable(),

                TextColumn::make('ends_at')
                    ->label(__('cms::announcements.ends_at'))
                    ->date()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('cms::common.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('cms::common.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('active')
                    ->label(__('cms::common.active'))
                    ->query(fn (Builder $query): Builder => $query->active())
                    ->toggle(),
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

    public static function getPages(): array
    {
        return [
            'index' => ManageAnnouncements::route('/'),
        ];
    }
}
