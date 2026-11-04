<?php

namespace SOSEventsBV\Cms\Traits;

use Filament\Facades\Filament;

trait HasCmsPagePermissions
{
    public static function canAccess(): bool
    {
        return Filament::auth()->user()?->hasPermission(static::class, 'manage') ?? false;
    }
}
