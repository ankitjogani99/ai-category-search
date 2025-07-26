<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/search', [SearchController::class, 'search']);
