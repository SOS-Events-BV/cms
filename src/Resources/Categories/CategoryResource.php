<?php

namespace SOSEventsBV\Cms\Resources\Categories;

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
use SOSEventsBV\Cms\Traits\HasCmsPermissions;

class CategoryResource extends Resource
{
    use HasCmsPermissions;

    protected static ?string $model = Category::class;
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedTag;
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|\UnitEnum|null $navigationGroup = "Producten";

    // Translate labels to Dutch
    protected static ?string $modelLabel = 'Categorie';
    protected static ?string $pluralModelLabel = 'Categorieën';
    protected static ?string $navigationLabel = 'Categorieën';

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
