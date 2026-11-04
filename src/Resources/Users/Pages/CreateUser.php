<?php

namespace SOSEventsBV\Cms\Resources\Users\Pages;

use Filament\Resources\Pages\CreateRecord;
use SOSEventsBV\Cms\Resources\Users\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
