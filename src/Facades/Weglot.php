<?php

namespace SOSEventsBV\Cms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SOSEventsBV\Cms\Weglot
 */
class Weglot extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SOSEventsBV\Cms\Weglot::class;
    }
}
