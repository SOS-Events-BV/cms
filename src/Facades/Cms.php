<?php

namespace SOSEventsBV\Cms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SOSEventsBV\Cms\Cms
 */
class Cms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SOSEventsBV\Cms\Cms::class;
    }
}
