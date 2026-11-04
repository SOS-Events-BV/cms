<?php

namespace SOSEventsBV\Cms\Resources\Products\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use SOSEventsBV\Cms\Resources\Products\ProductResource;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('showProductsPage')
                ->label('Toon alle producten pagina')
                ->icon(Heroicon::ShoppingBag)
                ->url(config('cms.routes.products') ? route(config('cms.routes.products')) : null)
                ->hidden(!config('cms.routes.products'))
                ->color('gray')
                ->openUrlInNewTab(),

            CreateAction::make(),
        ];
    }
}
