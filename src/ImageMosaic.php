<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic;

use Cieplik206\ImageMosaic\Layouts\GridLayout;
use Cieplik206\ImageMosaic\Layouts\HorizontalLayout;
use Cieplik206\ImageMosaic\Layouts\Layout;
use Cieplik206\ImageMosaic\Layouts\MasonryLayout;
use Cieplik206\ImageMosaic\Layouts\VerticalLayout;
use Cieplik206\ImageMosaic\Support\ImageCollection;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class ImageMosaic
{
    protected int $width;

    protected int $height;

    protected string $background = '#ffffff';

    protected int $padding = 0;

    protected int $gap = 0;

    protected int $borderRadius = 0;

    protected ImageCollection $images;

    protected ?Layout $layout = null;

    protected ?string $watermarkPath = null;

    protected string $watermarkPosition = 'bottom-right';

    protected float $watermarkOpacity = 0.5;

    protected ?ImageInterface $renderedImage = null;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->images = new ImageCollection;
    }

    public static function make(int $width, int $height): self
    {
        return new self($width, $height);
    }

    public function background(string $color): self
    {
        $this->background = $color;

        return $this;
    }

    public function padding(int $padding): self
    {
        $this->padding = $padding;

        return $this;
    }

    public function gap(int $gap): self
    {
        $this->gap = $gap;

        return $this;
    }

    public function borderRadius(int $radius): self
    {
        $this->borderRadius = $radius;

        return $this;
    }

    /**
     * @param  array<string>|ImageCollection  $images
     */
    public function images(array|ImageCollection $images): self
    {
        if ($images instanceof ImageCollection) {
            $this->images = $images;
        } else {
            $this->images = new ImageCollection($images);
        }

        return $this;
    }

    public function addImage(string $path): self
    {
        $this->images->add($path);

        return $this;
    }

    public function layout(string $type, int $columns = 3, int $rows = 0): self
    {
        $this->layout = match ($type) {
            'grid' => new GridLayout($columns, $rows),
            'horizontal' => new HorizontalLayout,
            'vertical' => new VerticalLayout,
            'masonry' => new MasonryLayout($columns),
            default => new GridLayout($columns, $rows),
        };

        return $this;
    }

    public function setLayout(Layout $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function watermark(string $path, string $position = 'bottom-right', float $opacity = 0.5): self
    {
        $this->watermarkPath = $path;
        $this->watermarkPosition = $position;
        $this->watermarkOpacity = $opacity;

        return $this;
    }

    public function render(): self
    {
        if ($this->images->isEmpty()) {
            $this->renderedImage = Image::create($this->width, $this->height)
                ->fill($this->background);

            return $this;
        }

        if ($this->layout === null) {
            $this->layout = new GridLayout(3);
        }

        $canvas = new Canvas(
            width: $this->width,
            height: $this->height,
            background: $this->background,
            padding: $this->padding,
            gap: $this->gap,
            borderRadius: $this->borderRadius,
        );

        $this->renderedImage = $this->layout->render($canvas, $this->images);

        if ($this->watermarkPath !== null) {
            $this->applyWatermark();
        }

        return $this;
    }

    protected function applyWatermark(): void
    {
        if ($this->renderedImage === null || $this->watermarkPath === null) {
            return;
        }

        $watermark = Image::read($this->watermarkPath);

        // Apply opacity
        if ($this->watermarkOpacity < 1.0) {
            $watermark = $watermark->reduceColors(256);
        }

        $position = match ($this->watermarkPosition) {
            'top-left' => 'top-left',
            'top-right' => 'top-right',
            'bottom-left' => 'bottom-left',
            'bottom-right' => 'bottom-right',
            'center' => 'center',
            default => 'bottom-right',
        };

        $this->renderedImage = $this->renderedImage->place(
            element: $watermark,
            position: $position,
            offset_x: $this->padding,
            offset_y: $this->padding,
            opacity: (int) ($this->watermarkOpacity * 100),
        );
    }

    public function getImage(): ?ImageInterface
    {
        return $this->renderedImage;
    }

    public function save(string $path, int $quality = 90): self
    {
        if ($this->renderedImage === null) {
            $this->render();
        }

        $this->renderedImage?->save($path, quality: $quality);

        return $this;
    }

    public function toJpeg(int $quality = 90): string
    {
        if ($this->renderedImage === null) {
            $this->render();
        }

        return $this->renderedImage?->toJpeg(quality: $quality)->toString() ?? '';
    }

    public function toPng(): string
    {
        if ($this->renderedImage === null) {
            $this->render();
        }

        return $this->renderedImage?->toPng()->toString() ?? '';
    }

    public function toWebp(int $quality = 90): string
    {
        if ($this->renderedImage === null) {
            $this->render();
        }

        return $this->renderedImage?->toWebp(quality: $quality)->toString() ?? '';
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getBackground(): string
    {
        return $this->background;
    }

    public function getPadding(): int
    {
        return $this->padding;
    }

    public function getGap(): int
    {
        return $this->gap;
    }

    public function getBorderRadius(): int
    {
        return $this->borderRadius;
    }
}
