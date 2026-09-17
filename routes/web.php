<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class)->name('main');

Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');

Route::get('/go/{offer}', [OfferController::class, 'redirect'])->name('offer.redirect');

Route::get('/sitemap.xml', SitemapController::class);
