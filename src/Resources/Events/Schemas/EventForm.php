<?php

namespace SOSEventsBV\Cms\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use SOSEventsBV\Cms\Models\Page;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('cms::common.name'))
                    ->required(),

                DateTimePicker::make('start_date')
                    ->label(__('cms::events.start_date'))
                    ->required(),

                DateTimePicker::make('end_date')
                    ->label(__('cms::events.end_date'))
                    ->required(),

                // Select the page from the `pages` table
                Select::make('page_id')
                    ->label(__('cms::events.page'))
                    ->relationship('page', 'slug')
                    ->getOptionLabelFromRecordUsing(fn(Page $record) => "{$record->seo->page_title} (/{$record->slug})")
                    ->searchable()
                    ->preload()
                    ->default(null),

                SpatieMediaLibraryFileUpload::make('images')
                    ->label(__('cms::events.images'))
                    ->collection('event')
                    ->disk('public')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->reorderable()
                    ->appendFiles()
                    ->getUploadedFileNameForStorageUsing(
                    // UUID-based, unique file name with original title + hash and extension
                        fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                            . '_' . Str::uuid()
                            . '.' . $file->getClientOriginalExtension()
                    )
                    ->panelLayout('grid')
                    ->columnSpanFull(),

                RichEditor::make('summary')
                    ->label(__('cms::events.summary'))
                    ->default(null)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label(__('cms::common.active'))
                    ->default(true),
            ]);
    }
}
