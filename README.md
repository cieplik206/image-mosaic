# Image Mosaic for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cieplik206/image-mosaic.svg?style=flat-square)](https://packagist.org/packages/cieplik206/image-mosaic)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/cieplik206/image-mosaic/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/cieplik206/image-mosaic/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/cieplik206/image-mosaic/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/cieplik206/image-mosaic/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/cieplik206/image-mosaic.svg?style=flat-square)](https://packagist.org/packages/cieplik206/image-mosaic)

Create beautiful image mosaics and collages with Laravel and Intervention Image v3. This package provides a fluent API to combine multiple images into grid, horizontal, vertical, or masonry layouts.

## Installation

You can install the package via composer:

```bash
composer require cieplik206/image-mosaic
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="image-mosaic-config"
```

This is the contents of the published config file:

```php
return [
    'default_width' => 800,
    'default_height' => 600,
    'default_background' => '#ffffff',
    'default_layout' => 'grid',
    'default_columns' => 3,
    'default_quality' => 90,
];
```

## Usage

### Basic Usage

```php
use Cieplik206\ImageMosaic\Facades\Mosaic;

// Create a simple grid mosaic
$mosaic = Mosaic::make(800, 600)
    ->images([
        '/path/to/image1.jpg',
        '/path/to/image2.jpg',
        '/path/to/image3.jpg',
        '/path/to/image4.jpg',
    ])
    ->layout('grid', columns: 2)
    ->render()
    ->save('/path/to/output.jpg');
```

### Available Layouts

#### Grid Layout
Creates a grid of NxM images:

```php
$mosaic = Mosaic::make(1200, 800)
    ->images($paths)
    ->layout('grid', columns: 3, rows: 2)
    ->render();
```

#### Horizontal Layout
Arranges images side by side:

```php
$mosaic = Mosaic::make(1200, 400)
    ->images($paths)
    ->layout('horizontal')
    ->render();
```

#### Vertical Layout
Stacks images vertically:

```php
$mosaic = Mosaic::make(400, 1200)
    ->images($paths)
    ->layout('vertical')
    ->render();
```

#### Masonry Layout (Pinterest-style)
Creates a masonry/waterfall layout preserving aspect ratios:

```php
$mosaic = Mosaic::make(1200, 1600)
    ->images($paths)
    ->layout('masonry', columns: 4)
    ->render();
```

### Styling Options

```php
$mosaic = Mosaic::make(1200, 800)
    ->background('#f5f5f5')     // Background color
    ->padding(16)               // Outer padding
    ->gap(8)                    // Gap between images
    ->borderRadius(12)          // Rounded corners
    ->images($paths)
    ->layout('grid', columns: 3)
    ->render();
```

### Adding a Watermark

```php
$mosaic = Mosaic::make(1200, 800)
    ->images($paths)
    ->layout('grid', columns: 3)
    ->watermark('/path/to/logo.png', 'bottom-right', opacity: 0.5)
    ->render();
```

Available watermark positions:
- `top-left`
- `top-right`
- `bottom-left`
- `bottom-right`
- `center`

### Output Formats

```php
// Save to file
$mosaic->save('/path/to/output.jpg', quality: 90);
$mosaic->save('/path/to/output.png');
$mosaic->save('/path/to/output.webp', quality: 85);

// Get as string
$jpegString = $mosaic->toJpeg(quality: 90);
$pngString = $mosaic->toPng();
$webpString = $mosaic->toWebp(quality: 85);

// Get Intervention Image instance for further processing
$image = $mosaic->getImage();
```

### Using Custom Layouts

You can create custom layouts by implementing the `Layout` interface:

```php
use Cieplik206\ImageMosaic\Layouts\Layout;
use Cieplik206\ImageMosaic\Canvas;
use Cieplik206\ImageMosaic\Support\ImageCollection;
use Intervention\Image\Interfaces\ImageInterface;

class CustomLayout implements Layout
{
    public function render(Canvas $canvas, ImageCollection $images): ImageInterface
    {
        // Your custom layout logic
        return $canvas->getImage();
    }
}

// Use your custom layout
$mosaic = Mosaic::make(800, 600)
    ->images($paths)
    ->setLayout(new CustomLayout())
    ->render();
```

### Using ImageCollection

```php
use Cieplik206\ImageMosaic\Support\ImageCollection;

$collection = new ImageCollection();
$collection->add('/path/to/image1.jpg');
$collection->add('/path/to/image2.jpg');
$collection->addMany(['/path/to/image3.jpg', '/path/to/image4.jpg']);

// Shuffle images randomly
$collection->shuffle();

$mosaic = Mosaic::make(800, 600)
    ->images($collection)
    ->layout('grid', columns: 2)
    ->render();
```

## Requirements

- PHP 8.2+
- Laravel 10.x, 11.x, or 12.x
- Intervention Image Laravel v1.0+

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Paweł Ciepliński](https://github.com/cieplik206)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
