<?php

use App\Http\Controllers\UrlShortener;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/url/shorten', [UrlShortener::class, 'shortenUrl'])->name('url.shorten');