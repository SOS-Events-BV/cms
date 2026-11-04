<?php

namespace SOSEventsBV\Cms\Resources\Products;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use SOSEventsBV\Cms\Models\Product;
use SOSEventsBV\Cms\Resources\Products\Pages\CreateProduct;
use SOSEventsBV\Cms\Resources\Products\Pages\EditProduct;
use SOSEventsBV\Cms\Resources\Products\Pages\ListProducts;
use SOSEventsBV\Cms\Resources\Products\Schemas\ProductForm;
use SOSEventsBV\Cms\Resources\Products\Tables\ProductsTable;
use SOSEventsBV\Cms\Traits\HasCmsPermissions;

class ProductResource extends Resource
{
    use HasCmsPermissions;

    protected static ?string $model = Product::class;
    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedShoppingBag;
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|null|\UnitEnum $navigationGroup = "Producten";

    // Translate labels to Dutch
    protected static ?string $modelLabel = 'Product';
    protected static ?string $pluralModelLabel = 'Producten';
    protected static ?string $navigationLabel = 'Producten';

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
