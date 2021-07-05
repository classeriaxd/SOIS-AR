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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// EVENT ROUTES
Route::get('/e/reports', [App\Http\Controllers\EventReportsController::class, 'index'])->middleware('auth');
Route::post('/e/reports', [App\Http\Controllers\EventReportsController::class, 'show'])->middleware('auth');
Route::get('/e/create', [App\Http\Controllers\EventsController::class, 'create'])->middleware('auth');
Route::get('/e/{event_slug}/edit', [App\Http\Controllers\EventsController::class, 'edit'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->middleware('auth');
Route::patch('/e/{event_slug}', [App\Http\Controllers\EventsController::class, 'update'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->middleware('auth');
Route::delete('/e/{event_slug}', [App\Http\Controllers\EventsController::class, 'destroy'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->name('event.destroy')->middleware('auth');
Route::get('/e/{event_slug}', [App\Http\Controllers\EventsController::class, 'show'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->name('event.show')->middleware('auth');
Route::get('/e', [App\Http\Controllers\EventsController::class, 'index'])->name('event.index')->middleware('auth');
Route::post('/e', [App\Http\Controllers\EventsController::class, 'store'])->middleware('auth');



Route::get('/e/{event_slug}/images/{eventImage_slug}/edit', [App\Http\Controllers\EventImagesController::class, 'edit'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$', 'eventImage_slug' => '^[a-zA-Z0-9-_]{2,255}$',])->middleware('auth');
Route::get('/e/{event_slug}/images/create', [App\Http\Controllers\EventImagesController::class, 'create'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->middleware('auth');
Route::get('/e/{event_slug}/images/{eventImage_slug}', [App\Http\Controllers\EventImagesController::class, 'show'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->middleware('auth');
Route::patch('/e/{event_slug}/images/{eventImage_slug}', [App\Http\Controllers\EventImagesController::class, 'update'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$', 'eventImage_slug' => '^[a-zA-Z0-9-_]{2,255}$',])->middleware('auth');
Route::delete('/e/{event_slug}/images/{eventImage_slug}', [App\Http\Controllers\EventImagesController::class, 'destroy'])->name('eventImage.destroy')->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$', 'eventImage_slug' => '^[a-zA-Z0-9-_]{2,255}$',])->middleware('auth');
Route::get('/e/{event_slug}/images', [App\Http\Controllers\EventImagesController::class, 'index'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->middleware('auth');
Route::post('/e/{event_slug}/images', [App\Http\Controllers\EventImagesController::class, 'store'])->where(['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->middleware('auth');



