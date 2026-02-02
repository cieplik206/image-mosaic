<?php

declare(strict_types=1);

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('it uses strict types')
    ->expect('Cieplik206\ImageMosaic')
    ->toUseStrictTypes();

arch('layouts implement Layout interface')
    ->expect('Cieplik206\ImageMosaic\Layouts\GridLayout')
    ->toImplement(\Cieplik206\ImageMosaic\Layouts\Layout::class);

arch('horizontal layout implements Layout interface')
    ->expect('Cieplik206\ImageMosaic\Layouts\HorizontalLayout')
    ->toImplement(\Cieplik206\ImageMosaic\Layouts\Layout::class);

arch('vertical layout implements Layout interface')
    ->expect('Cieplik206\ImageMosaic\Layouts\VerticalLayout')
    ->toImplement(\Cieplik206\ImageMosaic\Layouts\Layout::class);

arch('masonry layout implements Layout interface')
    ->expect('Cieplik206\ImageMosaic\Layouts\MasonryLayout')
    ->toImplement(\Cieplik206\ImageMosaic\Layouts\Layout::class);
