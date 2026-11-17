<?php

namespace SOSEventsBV\Cms\Resources\Products;

use SOSEventsBV\Cms\Enums\NavigationGroup;
use Override;
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

class ProductResource extends Resource
{

    protected static ?string $model = Product::class;
    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedShoppingBag;
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Products;

    #[Override]
    public static function getModelLabel(): string
    {
        return __('cms::products.product');
    }

    #[Override]
    public static function getPluralModelLabel(): string
    {
        return __('cms::products.products');
    }

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
