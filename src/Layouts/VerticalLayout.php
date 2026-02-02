<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic\Layouts;

use Cieplik206\ImageMosaic\Canvas;
use Cieplik206\ImageMosaic\Support\ImageCollection;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class VerticalLayout implements Layout
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
        $cellHeight = (int) floor(($contentHeight - $totalGaps) / $count);

        $y = $canvas->padding;

        foreach ($imageList as $imagePath) {
            $img = Image::read($imagePath);
            $img = $img->cover($contentWidth, $cellHeight);

            $canvas->placeWithBorderRadius(
                $img,
                $canvas->padding,
                $y,
                $canvas->borderRadius
            );

            $y += $cellHeight + $canvas->gap;
        }

        return $canvas->getImage();
    }
}
