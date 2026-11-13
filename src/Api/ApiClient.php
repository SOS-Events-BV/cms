<?php

namespace SOSEventsBV\Cms\Api;

use Illuminate\Http\Client\PendingRequest;

abstract class ApiClient
{
    abstract protected function client(): PendingRequest;
}
