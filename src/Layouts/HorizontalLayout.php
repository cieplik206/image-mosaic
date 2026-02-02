<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic\Layouts;

use Cieplik206\ImageMosaic\Canvas;
use Cieplik206\ImageMosaic\Support\ImageCollection;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class HorizontalLayout implements Layout
{
    public function render(Canvas $canvas, ImageCollection $images): ImageInterface
    {
        $imageList = $images->all();
        $count = count($imageList);

        if ($count === 0) {
            return $canvas->getImage();
        }

        $contentWidth = $canvas->getContentWidth();
        $contentHeight = $canvas->getContentHeight();

        $totalGaps = $canvas->gap * ($count - 1);
        $cellWidth = (int) floor(($contentWidth - $totalGaps) / $count);

        $x = $canvas->padding;

        foreach ($imageList as $imagePath) {
            $img = Image::read($imagePath);
            $img = $img->cover($cellWidth, $contentHeight);

            $canvas->placeWithBorderRadius(
                $img,
                $x,
                $canvas->padding,
                $canvas->borderRadius
            );

            $x += $cellWidth + $canvas->gap;
        }

        return $canvas->getImage();
    }
}
