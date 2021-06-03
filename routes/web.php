<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// EVENT ROUTES

Route::get('/e', [App\Http\Controllers\EventsController::class, 'index']);
Route::post('/e', [App\Http\Controllers\EventsController::class, 'store']);
Route::get('/e/reports', [App\Http\Controllers\EventReportsController::class, 'index']);
Route::post('/e/reports', [App\Http\Controllers\EventReportsController::class, 'show']);
Route::get('/e/create', [App\Http\Controllers\EventsController::class, 'create']);
Route::get('/e/{event}', [App\Http\Controllers\EventsController::class, 'show']);
Route::patch('/e/{event}', [App\Http\Controllers\EventsController::class, 'update']);
Route::delete('/e/{event}', [App\Http\Controllers\EventsController::class, 'destroy'])->name('event.destroy');
Route::get('/e/{event}/edit', [App\Http\Controllers\EventsController::class, 'edit']);



Route::get('/e/{event}/images/add', [App\Http\Controllers\EventImagesController::class, 'create']);
Route::get('/e/{event}/images', [App\Http\Controllers\EventImagesController::class, 'index']);
Route::post('/e/{event}/images', [App\Http\Controllers\EventImagesController::class, 'store']);
Route::get('/e/{event}/images/{eventImage}', [App\Http\Controllers\EventImagesController::class, 'show']);
Route::get('/e/{event}/images/{eventImage}/edit', [App\Http\Controllers\EventImagesController::class, 'edit']);
Route::patch('/e/{event}/images/{eventImage}', [App\Http\Controllers\EventImagesController::class, 'update']);
Route::delete('/e/{event}/images/{eventImage}', [App\Http\Controllers\EventImagesController::class, 'destroy'])->name('eventImage.destroy');


