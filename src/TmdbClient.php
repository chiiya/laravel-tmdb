<?php declare(strict_types=1);

namespace Chiiya\LaravelTmdb;

use Chiiya\Tmdb\Http\ClientInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use JsonSerializable;

class TmdbClient implements ClientInterface
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = $this->createClient();
    }

    /**
     * Perform a GET request.
     *
     * @throws RequestException
     */
    public function get(string $url, array $parameters = []): array
    {
        return $this->evaluate($this->client->get($url, $parameters));
    }

    /**
     * Perform a POST request.
     *
     * @throws RequestException
     */
    public function post(string $url, JsonSerializable $data): array
    {
        return $this->evaluate($this->client->post($url, $data->jsonSerialize()));
    }

    /**
     * Perform a PUT request.
     *
     * @throws RequestException
     */
    public function put(string $url, JsonSerializable $data): array
    {
        return $this->evaluate($this->client->put($url, $data->jsonSerialize()));
    }

    /**
     * Check for errors and return JSON decoded response.
     *
     * @throws RequestException
     */
    protected function evaluate(Response $response): array
    {
        $response->throw();

        return $response->json();
    }

    /**
     * Get the pre-configured base client.
     */
    protected function createClient(): PendingRequest
    {
        return Http::acceptJson()
            ->retry(2)
            ->baseUrl('https://api.themoviedb.org/3/')
            ->withToken(config('tmdb.token'));
    }
}
