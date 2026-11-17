<?php

namespace SOSEventsBV\Cms\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use SOSEventsBV\Cms\Traits\HasRestMethods;

class SosEventsClient extends ApiClient
{
    use HasRestMethods;

    protected string $url;
    protected string $apiKey;
    protected string $apiSecret;

    public function __construct()
    {
        $this->url = config('cms.services.sosevents.url');
        $this->apiKey = config('cms.services.sosevents.api_key');
        $this->apiSecret = config('cms.services.sosevents.api_secret');
    }

    /**
     * The configured HTTP client for this API.
     *
     * @return PendingRequest
     */
    protected function client(): PendingRequest
    {
        return Http::baseUrl($this->url)
            ->withHeaders([
                'X-API-KEY' => $this->apiKey,
                'X-API-SECRET' => $this->apiSecret,
            ])
            ->acceptJson();
    }

    /**
     * Name of the API, used in log messages.
     *
     * @return string
     */
    protected function name(): string
    {
        return 'SOS Events';
    }
}
