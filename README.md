# Laravel TMDB

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chiiya/laravel-tmdb.svg?style=flat-square)](https://packagist.org/packages/chiiya/laravel-tmdb)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/chiiya/laravel-tmdb/lint?label=code%20style)](https://github.com/chiiya/laravel-tmdb/actions?query=workflow%3Alint+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/chiiya/laravel-tmdb.svg?style=flat-square)](https://packagist.org/packages/chiiya/laravel-tmdb)

Laravel package for using the TMDB API.

## Installation

You can install the package via composer:

```bash
composer require chiiya/laravel-tmdb
```

Next, configure your TMDB API token in your .env file. This should be your
API Read Access Token (v4 auth):

```bash
TMDB_API_TOKEN="eyJh..."
```

## Usage

This package is a thin wrapper around [chiiya/tmdb-php](https://github.com/chiiya/tmdb-php), that allows you to directly
inject the repositories in your application:

```php
use Chiiya\Tmdb\Repositories\MovieRepository;
use Chiiya\Tmdb\Query\AppendToResponse;

class TmdbService {
    public function __construct(
        private MovieRepository $movies,
    )
    
    public function handle(): void
    {
        $this->movies->getMovie(550);
        $this->movies->getPopular();
        $movie = $this->movies->getMovie(550, [
            new AppendToResponse([
                AppendToResponse::IMAGES,
                AppendToResponse::WATCH_PROVIDERS,
            ]),
        ]);
        $movie->watch_providers['US']->flatrate[0]->provider_name;
    }
}
```

For documentation on method signatures, check out [chiiya/tmdb-php](https://github.com/chiiya/tmdb-php).

## Testing

Since this package uses the Laravel HTTP Client under the hood to perform API requests,
you may simply call `Http::fake()` to fake responses in your tests. For mocking specific responses,
check out the [example responses](https://github.com/chiiya/tmdb-php/tree/master/tests/responses).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
