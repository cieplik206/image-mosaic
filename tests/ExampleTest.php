<?php

declare(strict_types=1);

use Cieplik206\ImageMosaic\ImageMosaic;
use Cieplik206\ImageMosaic\Layouts\GridLayout;
use Cieplik206\ImageMosaic\Layouts\MasonryLayout;
use Cieplik206\ImageMosaic\Support\ImageCollection;

it('can create mosaic instance', function () {
    $mosaic = ImageMosaic::make(800, 600);

    expect($mosaic)->toBeInstanceOf(ImageMosaic::class)
        ->and($mosaic->getWidth())->toBe(800)
        ->and($mosaic->getHeight())->toBe(600);
});

it('can set background color', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->background('#f5f5f5');

    expect($mosaic->getBackground())->toBe('#f5f5f5');
});

it('can set padding', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->padding(16);

    expect($mosaic->getPadding())->toBe(16);
});

it('can set gap', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->gap(8);

    expect($mosaic->getGap())->toBe(8);
});

it('can set border radius', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->borderRadius(12);

    expect($mosaic->getBorderRadius())->toBe(12);
});

it('can chain configuration methods', function () {
    $mosaic = ImageMosaic::make(1200, 800)
        ->background('#000000')
        ->padding(20)
        ->gap(10)
        ->borderRadius(8);

    expect($mosaic->getWidth())->toBe(1200)
        ->and($mosaic->getHeight())->toBe(800)
        ->and($mosaic->getBackground())->toBe('#000000')
        ->and($mosaic->getPadding())->toBe(20)
        ->and($mosaic->getGap())->toBe(10)
        ->and($mosaic->getBorderRadius())->toBe(8);
});

it('can create image collection', function () {
    $collection = new ImageCollection;

    expect($collection)->toBeInstanceOf(ImageCollection::class)
        ->and($collection->isEmpty())->toBeTrue()
        ->and($collection->count())->toBe(0);
});

it('can add images to collection', function () {
    $collection = new ImageCollection;
    $collection->add('/path/to/image1.jpg');
    $collection->add('/path/to/image2.jpg');

    expect($collection->count())->toBe(2)
        ->and($collection->isEmpty())->toBeFalse()
        ->and($collection->isNotEmpty())->toBeTrue()
        ->and($collection->first())->toBe('/path/to/image1.jpg')
        ->and($collection->last())->toBe('/path/to/image2.jpg');
});

it('can create collection with initial images', function () {
    $collection = new ImageCollection([
        '/path/to/image1.jpg',
        '/path/to/image2.jpg',
        '/path/to/image3.jpg',
    ]);

    expect($collection->count())->toBe(3)
        ->and($collection->get(0))->toBe('/path/to/image1.jpg')
        ->and($collection->get(1))->toBe('/path/to/image2.jpg')
        ->and($collection->get(2))->toBe('/path/to/image3.jpg');
});

it('can clear collection', function () {
    $collection = new ImageCollection(['/path/to/image.jpg']);
    $collection->clear();

    expect($collection->isEmpty())->toBeTrue();
});

it('can iterate over collection', function () {
    $paths = ['/path/1.jpg', '/path/2.jpg'];
    $collection = new ImageCollection($paths);

    $iterated = [];
    foreach ($collection as $path) {
        $iterated[] = $path;
    }

    expect($iterated)->toBe($paths);
});

it('can set grid layout', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->layout('grid', columns: 4);

    expect($mosaic)->toBeInstanceOf(ImageMosaic::class);
});

it('can set horizontal layout', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->layout('horizontal');

    expect($mosaic)->toBeInstanceOf(ImageMosaic::class);
});

it('can set vertical layout', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->layout('vertical');

    expect($mosaic)->toBeInstanceOf(ImageMosaic::class);
});

it('can set masonry layout', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->layout('masonry', columns: 3);

    expect($mosaic)->toBeInstanceOf(ImageMosaic::class);
});

it('can set custom layout instance', function () {
    $layout = new GridLayout(5, 2);
    $mosaic = ImageMosaic::make(800, 600)
        ->setLayout($layout);

    expect($mosaic)->toBeInstanceOf(ImageMosaic::class);
});

it('grid layout has correct columns and rows', function () {
    $layout = new GridLayout(4, 3);

    expect($layout->getColumns())->toBe(4)
        ->and($layout->getRows())->toBe(3);
});

it('masonry layout has correct columns', function () {
    $layout = new MasonryLayout(5);

    expect($layout->getColumns())->toBe(5);
});

it('defaults to grid layout when unknown type', function () {
    $mosaic = ImageMosaic::make(800, 600)
        ->layout('unknown');

    expect($mosaic)->toBeInstanceOf(ImageMosaic::class);
});
