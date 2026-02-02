<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic\Layouts;

use Cieplik206\ImageMosaic\Canvas;
use Cieplik206\ImageMosaic\Support\ImageCollection;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class MasonryLayout implements Layout
{
    public function __construct(
        protected int $columns = 3,
    ) {}

    public function render(Canvas $canvas, ImageCollection $images): ImageInterface
    {
        $imageList = $images->all();
        $count = count($imageList);

        if ($count === 0) {
            return $canvas->getImage();
        }

        $columns = min($this->columns, $count);
        $contentWidth = $canvas->getContentWidth();

        $totalGaps = $canvas->gap * ($columns - 1);
        $columnWidth = (int) floor(($contentWidth - $totalGaps) / $columns);

        // Track the current height of each column
        /** @var array<int, int> $columnHeights */
        $columnHeights = array_fill(0, $columns, $canvas->padding);

        foreach ($imageList as $imagePath) {
            // Find the shortest column
            $shortestColumn = array_keys($columnHeights, min($columnHeights))[0];

            $img = Image::read($imagePath);

            // Scale width to fit column, maintain aspect ratio
            $scale = $columnWidth / $img->width();
            $newHeight = (int) floor($img->height() * $scale);

            $img = $img->resize($columnWidth, $newHeight);

            $x = $canvas->padding + ($shortestColumn * ($columnWidth + $canvas->gap));
            $y = $columnHeights[$shortestColumn];

            $canvas->placeWithBorderRadius(
                $img,
                $x,
                $y,
                $canvas->borderRadius
            );

            $columnHeights[$shortestColumn] += $newHeight + $canvas->gap;
        }

        return $canvas->getImage();
    }

    public function getColumns(): int
    {
        return $this->columns;
    }
}
