<?php

namespace SOSEventsBV\Cms\Resources\FaqPageQuestions;

use SOSEventsBV\Cms\Enums\NavigationGroup;
use Override;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use SOSEventsBV\Cms\Models\FaqPageQuestion;
use SOSEventsBV\Cms\Resources\FaqPageQuestions\Pages\ManageFaqPageQuestions;

class FaqPageQuestionResource extends Resource
{
    protected static ?string $model = FaqPageQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $recordTitleAttribute = 'question';

    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Pages;

    #[Override]
    public static function getModelLabel(): string
    {
        return __('cms::faq.question');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('cms::faq.questions');
    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('cms::faq.navigation_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Select, create, edit and delete FAQ categories
                Select::make('faq_page_category_id')
                    ->label(__('cms::faq.category'))
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        // Create a form for a category
                        TextInput::make('name')
                            ->label(__('cms::faq.category_name'))
                            ->required(),
                        RichEditor::make('description')
                            ->label(__('cms::faq.category_description'))
                    ])
                    ->editOptionForm([
                        // Edit form for category
                        TextInput::make('name')
                            ->label(__('cms::faq.category_name'))
                            ->required(),
                        RichEditor::make('description')
                            ->label(__('cms::faq.category_description'))
                    ])
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('question')
                    ->label(__('cms::faq.question'))
                    ->required()
                    ->columnSpanFull(),

                RichEditor::make('answer')
                    ->label(__('cms::faq.answer'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('category.name')
                    ->label(__('cms::faq.category')),

                TextColumn::make('question')
                    ->label(__('cms::faq.question'))
                    ->searchable(),

                TextColumn::make('answer')
                    ->label(__('cms::faq.answer'))
                    ->formatStateUsing(fn($state): string => strip_tags($state))
                    ->limit(75)
            ])
            ->filters([
                SelectFilter::make('faq_page_category_id')
                    ->label(__('cms::faq.category'))
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
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

    public static function getPages(): array
    {
        return [
            'index' => ManageFaqPageQuestions::route('/'),
        ];
    }
}
