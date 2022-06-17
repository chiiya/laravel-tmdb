<?php declare(strict_types=1);

namespace Chiiya\LaravelTmdb;

use Chiiya\Tmdb\Http\ClientInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use JsonSerializable;

class TmdbClient implements ClientInterface
{
    public function get(string $url, array $parameters = []): array
    {
        return $this->getClient()->get($url, $parameters)->json();
    }

    public function post(string $url, JsonSerializable $data): array
    {
        return $this->getClient()->post($url, $data->jsonSerialize())->json();
    }

    public function put(string $url, JsonSerializable $data): array
    {
        return $this->getClient()->put($url, $data->jsonSerialize())->json();
    }

    /**
     * Get the configured base client.
     */
    protected function getClient(): PendingRequest
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ])->withToken(config('tmdb.token'));
    }
}
