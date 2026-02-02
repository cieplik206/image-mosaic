<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ImageMosaicServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('image-mosaic')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(ImageMosaic::class, fn () => new ImageMosaic(
            width: config('image-mosaic.default_width', 800),
            height: config('image-mosaic.default_height', 600),
        ));
    }
}
