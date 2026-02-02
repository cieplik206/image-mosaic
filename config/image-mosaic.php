<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Canvas Width
    |--------------------------------------------------------------------------
    |
    | The default width of the mosaic canvas in pixels.
    |
    */
    'default_width' => 800,

    /*
    |--------------------------------------------------------------------------
    | Default Canvas Height
    |--------------------------------------------------------------------------
    |
    | The default height of the mosaic canvas in pixels.
    |
    */
    'default_height' => 600,

    /*
    |--------------------------------------------------------------------------
    | Default Background Color
    |--------------------------------------------------------------------------
    |
    | The default background color for the mosaic canvas.
    | Accepts hex colors (e.g., '#ffffff') or named colors.
    |
    */
    'default_background' => '#ffffff',

    /*
    |--------------------------------------------------------------------------
    | Default Layout
    |--------------------------------------------------------------------------
    |
    | The default layout to use when none is specified.
    | Options: 'grid', 'horizontal', 'vertical', 'masonry'
    |
    */
    'default_layout' => 'grid',

    /*
    |--------------------------------------------------------------------------
    | Default Grid Columns
    |--------------------------------------------------------------------------
    |
    | The default number of columns for grid and masonry layouts.
    |
    */
    'default_columns' => 3,

    /*
    |--------------------------------------------------------------------------
    | Default JPEG Quality
    |--------------------------------------------------------------------------
    |
    | The default quality setting when saving as JPEG or WebP.
    | Value between 1 and 100.
    |
    */
    'default_quality' => 90,
];
