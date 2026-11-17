<?php

namespace SOSEventsBV\Cms\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use SOSEventsBV\Cms\Traits\HasRestMethods;

class MailCampaignsClient extends ApiClient
{
    use HasRestMethods;

    protected string $url;
    protected string $apiKey;
    protected string $apiToken;

    public function __construct()
    {
        $this->url = config('cms.services.mailcampaigns.url');
        $this->apiKey = config('cms.services.mailcampaigns.api_key');
        $this->apiToken = config('cms.services.mailcampaigns.api_token');
    }

    /**
     * Client for MailCampaigns API.
     *
     * @return PendingRequest
     */
    protected function client(): PendingRequest
    {
        return Http::baseUrl($this->url)
            ->withHeaders([
                'api_key' => $this->apiKey,
                'api_token' => $this->apiToken,
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
        return 'MailCampaigns';
    }
}
