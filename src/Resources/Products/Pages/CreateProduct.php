<?php

namespace SOSEventsBV\Cms\Resources\Products\Pages;

use Filament\Resources\Pages\CreateRecord;
use SOSEventsBV\Cms\Resources\Products\ProductResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
