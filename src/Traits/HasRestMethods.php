<?php

namespace SOSEventsBV\Cms\Traits;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

/**
 * Adds public GET and POST methods to an API client.
 * Only use this in classes that extend `SOSEventsBV\Cms\Api\ApiClient`.
 */
trait HasRestMethods
{
    /**
     * Make a GET request to the API.
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
     * Make a POST request to the API.
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
