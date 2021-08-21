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
// NOTES 
// GET BEFORE POST
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// EVENT ROUTES
Route::get('/e/reports', [App\Http\Controllers\EventReportsController::class, 'index'])->middleware('auth');
Route::post('/e/reports', [App\Http\Controllers\EventReportsController::class, 'show'])->middleware('auth');
Route::get('/e/reports/print', [App\Http\Controllers\EventReportsController::class, 'pdf'])->middleware('auth');
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

Route::get('/n/{notice_uuid}', [App\Http\Controllers\MeetingNoticesController::class, 'show'])->where(['notice_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth')->name('meetingNotice.show');
Route::get('/n/{notice_uuid}/edit', [App\Http\Controllers\MeetingNoticesController::class, 'edit'])->where(['notice_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth');//->name('show');
Route::patch('/n/{notice_uuid}', [App\Http\Controllers\MeetingNoticesController::class, 'update'])->where(['notice_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth');
Route::delete('/n/{notice_uuid}', [App\Http\Controllers\MeetingNoticesController::class, 'destroy'])->where(['notice_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth');
Route::get('/n', [App\Http\Controllers\MeetingNoticesController::class, 'index'])->name('meetingnotices.index')->middleware('auth');
Route::get('/n/create', [App\Http\Controllers\MeetingNoticesController::class, 'create'])->middleware('auth');
Route::post('/n', [App\Http\Controllers\MeetingNoticesController::class, 'store'])->middleware('auth');

Route::get('/o/documents/create', [App\Http\Controllers\DocumentManagementController::class, 'create'])->middleware('auth');
Route::post('/o/documents', [App\Http\Controllers\DocumentManagementController::class, 'store'])->middleware('auth');

Route::delete('/s/accomplishments/upload/revert', [App\Http\Controllers\StudentAccomplishmentsController::class, 'undoUpload'])->middleware('auth');
Route::get('/s/accomplishment/{accomplishment_uuid}', [App\Http\Controllers\StudentAccomplishmentsController::class, 'show'])->where(['accomplishment_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth')->name('student_accomplishment.show');
Route::get('/s/accomplishments/create', [App\Http\Controllers\StudentAccomplishmentsController::class, 'create'])->middleware('auth');
Route::post('/s/accomplishments/upload', [App\Http\Controllers\StudentAccomplishmentsController::class, 'upload'])->middleware('auth');
Route::get('/s/accomplishments', [App\Http\Controllers\StudentAccomplishmentsController::class, 'index'])->middleware('auth');
Route::post('/s/accomplishments', [App\Http\Controllers\StudentAccomplishmentsController::class, 'store'])->middleware('auth');

