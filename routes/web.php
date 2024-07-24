<?php

use App\Http\Controllers\UrlShortener;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{path}', [UrlShortener::class, 'retrieveUrl'])->name('url.retrieve');

Route::prefix('url')->group(function () {
    Route::post('shorten', [UrlShortener::class, 'shortenUrl'])->name('url.shorten');
});