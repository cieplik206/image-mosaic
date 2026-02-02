<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic\Layouts;

use Cieplik206\ImageMosaic\Canvas;
use Cieplik206\ImageMosaic\Support\ImageCollection;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class GridLayout implements Layout
{
    public function __construct(
        protected int $columns = 3,
        protected int $rows = 0,
    ) {}

    public function render(Canvas $canvas, ImageCollection $images): ImageInterface
    {
        $imageList = $images->all();
        $count = count($imageList);

        if ($count === 0) {
            return $canvas->getImage();
        }

        $columns = min($this->columns, $count);
        $rows = $this->rows > 0 ? $this->rows : (int) ceil($count / $columns);

        $contentWidth = $canvas->getContentWidth();
        $contentHeight = $canvas->getContentHeight();

        $totalGapX = $canvas->gap * ($columns - 1);
        $totalGapY = $canvas->gap * ($rows - 1);

        $cellWidth = (int) floor(($contentWidth - $totalGapX) / $columns);
        $cellHeight = (int) floor(($contentHeight - $totalGapY) / $rows);

        $index = 0;
        for ($row = 0; $row < $rows && $index < $count; $row++) {
            for ($col = 0; $col < $columns && $index < $count; $col++) {
                $imagePath = $imageList[$index];

                $img = Image::read($imagePath);
                $img = $this->fitImage($img, $cellWidth, $cellHeight);

                $x = $canvas->padding + ($col * ($cellWidth + $canvas->gap));
                $y = $canvas->padding + ($row * ($cellHeight + $canvas->gap));

                // Center the image in the cell if it's smaller
                $offsetX = (int) floor(($cellWidth - $img->width()) / 2);
                $offsetY = (int) floor(($cellHeight - $img->height()) / 2);

                $canvas->placeWithBorderRadius(
                    $img,
                    $x + $offsetX,
                    $y + $offsetY,
                    $canvas->borderRadius
                );

                $index++;
            }
        }

        return $canvas->getImage();
    }

    protected function fitImage(ImageInterface $image, int $maxWidth, int $maxHeight): ImageInterface
    {
        return $image->cover($maxWidth, $maxHeight);
    }

    public function getColumns(): int
    {
        return $this->columns;
    }

    public function getRows(): int
    {
        return $this->rows;
    }
}
