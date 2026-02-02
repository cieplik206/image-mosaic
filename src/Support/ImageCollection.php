<?php

declare(strict_types=1);

namespace Cieplik206\ImageMosaic\Support;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, string>
 */
class ImageCollection implements Countable, IteratorAggregate
{
    /** @var array<int, string> */
    protected array $images = [];

    /**
     * @param  array<string>  $images
     */
    public function __construct(array $images = [])
    {
        foreach ($images as $image) {
            $this->add($image);
        }
    }

    public function add(string $path): self
    {
        $this->images[] = $path;

        return $this;
    }

    /**
     * @param  array<string>  $paths
     */
    public function addMany(array $paths): self
    {
        foreach ($paths as $path) {
            $this->add($path);
        }

        return $this;
    }

    public function get(int $index): ?string
    {
        return $this->images[$index] ?? null;
    }

    /**
     * @return array<int, string>
     */
    public function all(): array
    {
        return $this->images;
    }

    public function count(): int
    {
        return count($this->images);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    public function first(): ?string
    {
        return $this->images[0] ?? null;
    }

    public function last(): ?string
    {
        if ($this->isEmpty()) {
            return null;
        }

        return $this->images[$this->count() - 1];
    }

    public function clear(): self
    {
        $this->images = [];

        return $this;
    }

    public function shuffle(): self
    {
        shuffle($this->images);

        return $this;
    }

    /**
     * @return Traversable<int, string>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->images);
    }
}
