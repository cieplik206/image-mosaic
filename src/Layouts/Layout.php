<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic\Layouts;

use Cieplik206\ImageMosaic\Canvas;
use Cieplik206\ImageMosaic\Support\ImageCollection;
use Intervention\Image\Interfaces\ImageInterface;

interface Layout
{
    public function render(Canvas $canvas, ImageCollection $images): ImageInterface;
}
