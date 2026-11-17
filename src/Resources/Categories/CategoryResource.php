<?php

namespace SOSEventsBV\Cms\Resources\Categories;

use SOSEventsBV\Cms\Enums\NavigationGroup;
use Override;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use SOSEventsBV\Cms\Models\Category;
use SOSEventsBV\Cms\Resources\Categories\Pages\CreateCategory;
use SOSEventsBV\Cms\Resources\Categories\Pages\EditCategory;
use SOSEventsBV\Cms\Resources\Categories\Pages\ListCategories;
use SOSEventsBV\Cms\Resources\Categories\Schemas\CategoryForm;
use SOSEventsBV\Cms\Resources\Categories\Tables\CategoriesTable;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedTag;
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Products;

    #[Override]
    public static function getModelLabel(): string
    {
        return __('cms::categories.category');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('cms::categories.categories');
    }

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
