<?php

namespace SOSEventsBV\Cms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SOSEventsBV\Cms\Seo
 */
class Seo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SOSEventsBV\Cms\Seo::class;
    }
}
