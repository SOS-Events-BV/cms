<?php

namespace SOSEventsBV\Cms\Resources\Pages;

use SOSEventsBV\Cms\Enums\NavigationGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Override;
use SOSEventsBV\Cms\Models\Page;
use SOSEventsBV\Cms\Resources\Pages\Pages\CreatePage;
use SOSEventsBV\Cms\Resources\Pages\Pages\EditPage;
use SOSEventsBV\Cms\Resources\Pages\Pages\ListPages;
use SOSEventsBV\Cms\Resources\Pages\Schemas\PageForm;
use SOSEventsBV\Cms\Resources\Pages\Tables\PagesTable;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Pages;

    protected static ?string $recordTitleAttribute = 'seo.page_title';

    #[Override]
    public static function getModelLabel(): string
    {
        return __('cms::pages.page');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('cms::pages.pages');
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->seo->page_title;
    }

    public static function form(Schema $schema): Schema
    {
        return PageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
