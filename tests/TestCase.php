<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic\Tests;

use Cieplik206\ImageMosaic\ImageMosaicServiceProvider;
use Intervention\Image\Laravel\ServiceProvider as ImageServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ImageServiceProvider::class,
            ImageMosaicServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }

    protected function getTestImagePath(string $filename = 'test.jpg'): string
    {
        return __DIR__.'/fixtures/'.$filename;
    }
}
