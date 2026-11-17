<?php

namespace SOSEventsBV\Cms\Api;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class MailCampaignsClient extends ApiClient
{
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

    /**
     * Make a GET request to the MailCampaigns API.
     *
     * @param string $endpoint
     * @param array $parameters Query parameters.
     * @return Collection
     * @throws RequestException
     * @throws ConnectionException
     */
    public function get(string $endpoint, array $parameters = []): Collection
    {
        return $this->send('GET', $endpoint, $parameters);
    }

    /**
     * Make a POST request to the MailCampaigns API.
     *
     * @param string $endpoint
     * @param array $parameters JSON body.
     * @return Collection
     * @throws RequestException
     * @throws ConnectionException
     */
    public function post(string $endpoint, array $parameters = []): Collection
    {
        return $this->send('POST', $endpoint, $parameters);
    }
}
