<?php

namespace SOSEventsBV\Cms\Resources\Events\Pages;

use Filament\Resources\Pages\CreateRecord;
use SOSEventsBV\Cms\Resources\Events\EventResource;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
}
