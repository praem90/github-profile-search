<?php

use App\Http\Controllers\PopularProfilesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\RequestLogMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

	Route::get('/dashboard', function () {
    	return view('dashboard');
	})->name('dashboard');

	Route::middleware(RequestLogMiddleware::class)->get('profile/search', SearchController::class)->name('search');

	Route::middleware(RequestLogMiddleware::class)->get('profile/popular', PopularProfilesController::class)->name('popular');
	Route::middleware(RequestLogMiddleware::class)->get('profile/{username}', ProfileController::class)->name('profile');
});

require __DIR__.'/auth.php';
