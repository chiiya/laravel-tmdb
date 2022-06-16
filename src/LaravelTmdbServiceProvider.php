<?php declare(strict_types=1);

namespace Chiiya\LaravelTmdb;

use Chiiya\Tmdb\Http\ClientInterface;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelTmdbServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-tmdb')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(ClientInterface::class, TmdbClient::class);
    }
}
