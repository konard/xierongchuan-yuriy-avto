<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('catalog:stats', function (): void {
    $this->info('Yuriy Avto catalog is served dynamically by Laravel.');
})->purpose('Show catalog implementation details');
