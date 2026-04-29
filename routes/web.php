<?php

use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/cars/{brand}', [CatalogController::class, 'brand'])->name('brands.show');
Route::get('/cities/{city}', [CatalogController::class, 'city'])->name('cities.show');
Route::get('/cars/{brand}/{city}', [CatalogController::class, 'landing'])->name('landings.show');
Route::get('/sitemap.xml', [CatalogController::class, 'sitemap'])->name('sitemap');
Route::view('/robots.txt', 'robots')->name('robots');
