<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class Canvas
{
    protected ImageInterface $image;

    public function __construct(
        public readonly int $width,
        public readonly int $height,
        public readonly string $background = '#ffffff',
        public readonly int $padding = 0,
        public readonly int $gap = 0,
        public readonly int $borderRadius = 0,
    ) {
        $this->image = Image::create($this->width, $this->height)
            ->fill($this->background);
    }

    public function getImage(): ImageInterface
    {
        return $this->image;
    }

    public function getContentWidth(): int
    {
        return $this->width - ($this->padding * 2);
    }

    public function getContentHeight(): int
    {
        return $this->height - ($this->padding * 2);
    }

    public function place(ImageInterface $image, int $x, int $y): self
    {
        $this->image = $this->image->place(
            element: $image,
            position: 'top-left',
            offset_x: $x,
            offset_y: $y,
        );

        return $this;
    }

    public function placeWithBorderRadius(ImageInterface $image, int $x, int $y, int $radius): self
    {
        if ($radius > 0) {
            $image = $this->applyBorderRadius($image, $radius);
        }

        return $this->place($image, $x, $y);
    }

    /**
     * Apply border radius to an image.
     *
     * Note: This is a placeholder for future implementation.
     * Intervention Image v3 requires custom masking for rounded corners.
     */
    protected function applyBorderRadius(ImageInterface $image, int $radius): ImageInterface
    {
        // TODO: Implement border radius using GD/Imagick masking
        // For now, return the image unchanged
        return $image;
    }
}
