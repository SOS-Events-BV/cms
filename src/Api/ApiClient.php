<?php

namespace SOSEventsBV\Cms\Api;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

abstract class ApiClient
{
    /**
     * The configured HTTP client for this API.
     *
     * @return PendingRequest
     */
    abstract protected function client(): PendingRequest;

    /**
     * Name of the API, used in log messages.
     *
     * @return string
     */
    abstract protected function name(): string;

    /**
     * Send a request to the API. Errors are logged and then rethrown, so the caller can handle them.
     *
     * @param string $method The HTTP method, e.g. `GET` or `POST`.
     * @param string $endpoint The endpoint, relative to the base URL of the client.
     * @param array $data Query parameters for `GET`, JSON body for other methods.
     * @param string|null $key Only return this key of the response (dot notation), e.g. `data`.
     * @return Collection
     * @throws RequestException
     * @throws ConnectionException
     */
    protected function send(string $method, string $endpoint, array $data = [], ?string $key = null): Collection
    {
        $method = strtoupper($method);

        try {
            return $this->client()
                ->throw()
                ->send($method, $endpoint, [
                    $method === 'GET' ? 'query' : 'json' => $data,
                ])
                ->collect($key);
        } catch (RequestException|ConnectionException $e) {
            Log::error("{$this->name()} API {$method} request error: {$e->getMessage()}", [
                'endpoint' => $endpoint,
                'parameters' => array_keys($data),
            ]);

            throw $e;
        }
    }
}
