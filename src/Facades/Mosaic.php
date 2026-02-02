<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic\Facades;

use Cieplik206\ImageMosaic\ImageMosaic;
use Illuminate\Support\Facades\Facade;

/**
 * @method static ImageMosaic make(int $width, int $height)
 *
 * @see \Cieplik206\ImageMosaic\ImageMosaic
 */
class Mosaic extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ImageMosaic::class;
    }
}
