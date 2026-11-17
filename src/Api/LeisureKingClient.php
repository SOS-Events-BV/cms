<?php

namespace SOSEventsBV\Cms\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Exception;
use InvalidArgumentException;

class LeisureKingClient extends ApiClient
{
    protected string $baseUrl;
    protected string $version;
    protected string $environment;
    protected string $shophid;

    public function __construct()
    {
        $this->baseUrl = config('cms.services.leisureking.url');
        $this->version = config('cms.services.leisureking.version');
        $this->shophid = config('cms.services.leisureking.shophid');
        $this->environment = config('cms.services.leisureking.environment');
    }

    /**
     * Client for LeisureKing API.
     *
     * @return PendingRequest
     */
    protected function client(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->withToken($this->getToken(), 'Token');
    }

    /**
     * Make a request to the LeisureKing API.
     *
     * @param string $endpoint Endpoint to request, without `https://www.api.leisureking.eu/public`, start with / and without version. `https://www.api.leisureking.eu/public/assortment/get/v4` becomes `/assortment/get`.
     * @param array $data The POST data to be added.
     * @param string|null $version The version of the API to use. If not provided, the version from the config will be used.
     * @return Collection The response data.
     * @throws ConnectionException
     * @throws RequestException
     */
    public function request(string $endpoint, array $data = [], ?string $version = null): Collection
    {
        // Create payload, with required data and given data
        $payload = array_merge($data, [
            'environment' => $this->environment,
            'shophid' => $this->shophid,
        ]);

        // Create the URL, remove / from string
        $url = trim($endpoint, '/') . '/' . ($version ?? $this->version);

        return $this->send('POST', $url, $payload, 'data');
    }

    /**
     * Name of the API, used in log messages.
     *
     * @return string
     */
    protected function name(): string
    {
        return 'LeisureKing';
    }

    /**
     * Get the JWT-token from the LeisureKing API. This token will be cached for 10 minutes per environment.
     *
     * @return string
     */
    protected function getToken(): string
    {
        // Cache the JWT-token for 10 minutes (max LK is 15 minutes)
        return Cache::remember("leisureking_token.{$this->environment}", 600, function () {
            try {
                $response = Http::post("{$this->baseUrl}/authenticate/{$this->version}", [
                    'username' => config('cms.services.leisureking.username'),
                    'password' => config('cms.services.leisureking.password'),
                    'environment' => $this->environment,
                ]);

                $response->throw(); // Throw error if auth fails

                return $response->json('data.token'); // Return the JWT-token
            } catch (Exception $e) {
                Log::error("LeisureKing API Auth Error: {$e->getMessage()}", [
                    'url' => "{$this->baseUrl}/authenticate/{$this->version}",
                    'username' => config('cms.services.leisureking.username'),
                ]);

                throw $e;
            }
        });
    }

    /**
     * Set the API version of the LeisureKing client.
     *
     * @param string $version
     * @return void
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * Set the environment (`test` or `production`) of the LeisureKing client.
     *
     * @param string $environment `test` or `production`
     * @return void
     * @throws InvalidArgumentException
     */
    public function setEnvironment(string $environment)
    {
        if (!in_array($environment, ['test', 'production'])) {
            throw new InvalidArgumentException(
                sprintf('Invalid environment "%s", expected "test" or "production".', $environment)
            );
        }

        $this->environment = $environment;
    }

    /**
     * Set the shophid of the LeisureKing client.
     *
     * @param string $shophid
     * @return void
     */
    public function setShopHid(string $shophid)
    {
        $this->shophid = $shophid;
    }
}
