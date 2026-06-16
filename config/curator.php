<?php

return [
    'disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'directory' => 'media',
    'glide' => [
        'route_path' => 'storage',],
    // Falls back to APP_KEY so a missing CURATOR_GLIDE_TOKEN never 500s after deploy
    'glide_token' => env('CURATOR_GLIDE_TOKEN', env('APP_KEY')),
];
