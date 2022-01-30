<?php

use App\Http\Controllers\PopularProfilesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\RequestLogMiddleware;


/**
 * Routes used for search github profiles
 *
 * Isolated into a seperate file to use anyware
 */
Route::middleware(RequestLogMiddleware::class)->get('profile/search', SearchController::class)->name('search');

Route::middleware(RequestLogMiddleware::class)->get('profile/popular', PopularProfilesController::class)->name('popular');
Route::middleware(RequestLogMiddleware::class)->get('profile/{username}', ProfileController::class)->name('profile');
