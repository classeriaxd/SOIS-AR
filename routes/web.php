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
// halep me organize this shit ples
Auth::routes();

// Sorted Routes
    Route::group(['middleware' => 'auth'], function () {

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        
        // Admin Routes
        Route::group([
                'as' => 'admin.',
                'prefix' => '/admin',], 
            function () {
                Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

            // Maintenance Routes
            Route::group([
                    'as' => 'maintenance.',
                    'prefix' => '/maintenance',], 
                function () {

                // Event Category Maintenance
                Route::resource('eventCategories', App\Http\Controllers\Admin\EventMaintenance\EventCategoryMaintenanceController::class)->only(['index', 'create', 'store']);
                
                Route::group([
                        'as' => 'eventCategories.',
                        'prefix' => '/eventCategories/{category_id}',
                        'where' => ['category_id' => '^([1-9][0-9]*)$'],], 
                    function () {
                        Route::get('/edit', [App\Http\Controllers\Admin\EventMaintenance\EventCategoryMaintenanceController::class, 'edit'])->name('edit');
                        Route::get('', [App\Http\Controllers\Admin\EventMaintenance\EventCategoryMaintenanceController::class, 'show'])->name('show');
                        Route::patch('', [App\Http\Controllers\Admin\EventMaintenance\EventCategoryMaintenanceController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\Admin\EventMaintenance\EventCategoryMaintenanceController::class, 'destroy'])->name('destroy');
                }); 

                // Event Role Maintenance
                Route::resource('eventRoles', App\Http\Controllers\Admin\EventMaintenance\EventRoleMaintenanceController::class)->only(['index', 'create', 'store']);
                
                Route::group([
                        'as' => 'eventRoles.',
                        'prefix' => '/eventRoles/{role_id}',
                        'where' => ['role_id' => '^([1-9][0-9]*)$'],], 
                    function () {
                        Route::get('/edit', [App\Http\Controllers\Admin\EventMaintenance\EventRoleMaintenanceController::class, 'edit'])->name('edit');
                        Route::get('', [App\Http\Controllers\Admin\EventMaintenance\EventRoleMaintenanceController::class, 'show'])->name('show');
                        Route::patch('', [App\Http\Controllers\Admin\EventMaintenance\EventRoleMaintenanceController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\Admin\EventMaintenance\EventRoleMaintenanceController::class, 'destroy'])->name('destroy');
                });

                // Event Nature Maintenance
                Route::resource('eventNatures', App\Http\Controllers\Admin\EventMaintenance\EventNatureMaintenanceController::class)->only(['index', 'create', 'store']);
                
                Route::group([
                        'as' => 'eventNatures.',
                        'prefix' => '/eventNatures/{nature_id}',
                        'where' => ['nature_id' => '^([1-9][0-9]*)$'],], 
                    function () {
                        Route::get('/edit', [App\Http\Controllers\Admin\EventMaintenance\EventNatureMaintenanceController::class, 'edit'])->name('edit');
                        Route::get('', [App\Http\Controllers\Admin\EventMaintenance\EventNatureMaintenanceController::class, 'show'])->name('show');
                        Route::patch('', [App\Http\Controllers\Admin\EventMaintenance\EventNatureMaintenanceController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\Admin\EventMaintenance\EventNatureMaintenanceController::class, 'destroy'])->name('destroy');
                }); 

                // Event Classification Maintenance
                Route::resource('eventClassifications', App\Http\Controllers\Admin\EventMaintenance\EventClassificationMaintenanceController::class)->only(['index', 'create', 'store']);
                
                Route::group([
                        'as' => 'eventClassifications.',
                        'prefix' => '/eventClassifications/{classification_id}',
                        'where' => ['classification_id' => '^([1-9][0-9]*)$'],], 
                    function () {
                        Route::get('/edit', [App\Http\Controllers\Admin\EventMaintenance\EventClassificationMaintenanceController::class, 'edit'])->name('edit');
                        Route::get('', [App\Http\Controllers\Admin\EventMaintenance\EventClassificationMaintenanceController::class, 'show'])->name('show');
                        Route::patch('', [App\Http\Controllers\Admin\EventMaintenance\EventClassificationMaintenanceController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\Admin\EventMaintenance\EventClassificationMaintenanceController::class, 'destroy'])->name('destroy');
                });

                // Event Document Type Maintenance
                Route::resource('eventDocumentTypes', App\Http\Controllers\Admin\EventMaintenance\EventDocumentTypeMaintenanceController::class)->only(['index', 'create', 'store']);
                
                Route::group([
                        'as' => 'eventDocumentTypes.',
                        'prefix' => '/eventDocumentTypes/{document_type_id}',
                        'where' => ['document_type_id' => '^([1-9][0-9]*)$'],], 
                    function () {
                        Route::get('/edit', [App\Http\Controllers\Admin\EventMaintenance\EventDocumentTypeMaintenanceController::class, 'edit'])->name('edit');
                        Route::get('', [App\Http\Controllers\Admin\EventMaintenance\EventDocumentTypeMaintenanceController::class, 'show'])->name('show');
                        Route::patch('', [App\Http\Controllers\Admin\EventMaintenance\EventDocumentTypeMaintenanceController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\Admin\EventMaintenance\EventDocumentTypeMaintenanceController::class, 'destroy'])->name('destroy');
                });

                // Fund Source Maintenance
                Route::resource('fundSources', App\Http\Controllers\Admin\EventMaintenance\FundSourceMaintenanceController::class)->only(['index', 'create', 'store']);
                
                Route::group([
                        'as' => 'fundSources.',
                        'prefix' => '/fundSources/{fund_source_id}',
                        'where' => ['fund_source_id' => '^([1-9][0-9]*)$'],], 
                    function () {
                        Route::get('/edit', [App\Http\Controllers\Admin\EventMaintenance\FundSourceMaintenanceController::class, 'edit'])->name('edit');
                        Route::get('', [App\Http\Controllers\Admin\EventMaintenance\FundSourceMaintenanceController::class, 'show'])->name('show');
                        Route::patch('', [App\Http\Controllers\Admin\EventMaintenance\FundSourceMaintenanceController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\Admin\EventMaintenance\FundSourceMaintenanceController::class, 'destroy'])->name('destroy');
                });

                // Level Maintenance
                Route::resource('levels', App\Http\Controllers\Admin\EventMaintenance\LevelMaintenanceController::class)->only(['index', 'create', 'store']);
                
                Route::group([
                        'as' => 'levels.',
                        'prefix' => '/levels/{level_id}',
                        'where' => ['level_id' => '^([1-9][0-9]*)$'],], 
                    function () {
                        Route::get('/edit', [App\Http\Controllers\Admin\EventMaintenance\LevelMaintenanceController::class, 'edit'])->name('edit');
                        Route::get('', [App\Http\Controllers\Admin\EventMaintenance\LevelMaintenanceController::class, 'show'])->name('show');
                        Route::patch('', [App\Http\Controllers\Admin\EventMaintenance\LevelMaintenanceController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\Admin\EventMaintenance\LevelMaintenanceController::class, 'destroy'])->name('destroy');
                });

                // Tabular Table Maintenance
                Route::resource('tabularTables', App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularTableMaintenanceController::class)->only(['index', 'create', 'store']);
                
                Route::group([
                        'as' => 'tabularTables.',
                        'prefix' => '/tabularTables/{tabular_table_id}',
                        'where' => ['tabular_table_id' => '^([1-9][0-9]*)$'],], 
                    function () {
                        Route::get('/edit', [App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularTableMaintenanceController::class, 'edit'])->name('edit');
                        Route::get('', [App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularTableMaintenanceController::class, 'show'])->name('show');
                        Route::patch('', [App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularTableMaintenanceController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularTableMaintenanceController::class, 'destroy'])->name('destroy');

                        // Tabular Column Maintenance
                        Route::resource('tabularColumns', App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularColumnMaintenanceController::class)->only(['create', 'store']);
                        
                        Route::group([
                                'as' => 'tabularColumns.',
                                'prefix' => '/tabularColumns/{tabular_column_id}',
                                'where' => ['tabular_column_id' => '^([1-9][0-9]*)$'],], 
                            function () {
                                Route::get('/edit', [App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularColumnMaintenanceController::class, 'edit'])->name('edit');
                                Route::get('', [App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularColumnMaintenanceController::class, 'show'])->name('show');
                                Route::patch('', [App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularColumnMaintenanceController::class, 'update'])->name('update');
                                Route::delete('', [App\Http\Controllers\Admin\AccomplishmentReportMaintenance\TabularColumnMaintenanceController::class, 'destroy'])->name('destroy');
                        });
                });

                
            });
            

            Route::group([
                    'as' => 'events.',
                    'prefix' => '/events',],
                function () {
                    Route::get('/{organization_slug}/{event_slug}', [App\Http\Controllers\Admin\AdminEventsController::class, 'show'])->where(['organization_slug' => '^[a-zA-Z0-9_-]{2,255}$', 'event_slug' => '^[a-zA-Z0-9-_]{2,255}$'])->name('show');
                    Route::get('/{organization_slug}', [App\Http\Controllers\Admin\AdminEventsController::class, 'organizationIndex'])->where(['organization_slug' => '^[a-zA-Z0-9_-]{2,255}$'])->name('organization.index');
                    Route::get('', [App\Http\Controllers\Admin\AdminEventsController::class, 'index'])->name('index');

            });

        });

        // Show and Review of Accomplishment report
        Route::group([
                'as' => 'accomplishmentReport.',
                'prefix' => '/e/report/{accomplishmentReportUUID}',
                'where' => ['accomplishmentReportUUID' => '^[a-zA-Z0-9-]{36}$'],], 
            function () {
                Route::post('/review/finalize', [App\Http\Controllers\AccomplishmentReportsController::class, 'finalizeReview'])->name('finalizeReview');
                Route::get('/review', [App\Http\Controllers\AccomplishmentReportsController::class, 'review'])->name('review');
                Route::get('/download', [App\Http\Controllers\AccomplishmentReportsController::class, 'downloadAccomplishmentReport'])->name('download');
                Route::get('/{newAccomplishmentReport?}', [App\Http\Controllers\AccomplishmentReportsController::class, 'show'])->name('show');
        });

        // Accomplishment Reports
        Route::group([
                'as' => 'accomplishmentreports.',
                'prefix' => '/e/reports'], 
            function () {
                Route::post('/create/finalize', [App\Http\Controllers\AccomplishmentReportsController::class, 'finalizeReport'])->name('finalizeReport');
                Route::post('/create/checklist', [App\Http\Controllers\AccomplishmentReportsController::class, 'showChecklist'])->name('showChecklist');
                Route::get('/create', [App\Http\Controllers\AccomplishmentReportsController::class, 'create'])->name('create');
                Route::get('/tabular', [App\Http\Controllers\AccomplishmentReportsController::class, 'tabularAR']);
                Route::get('', [App\Http\Controllers\AccomplishmentReportsController::class, 'index'])->name('index');

                // Fallback for POST-only Routes
                Route::any('/create/checklist', function () {
                    abort(404);
                });
                Route::any('/create/finalize', function () {
                    abort(404);
                });
        });

        // Events
        Route::group([
                'as' => 'event.',
                'prefix' => '/e'], 
            function () {
                // Event
                // --> /e

                Route::delete('/images/upload/revert', [App\Http\Controllers\EventImagesController::class, 'undoUpload']);
                Route::post('/images/upload', [App\Http\Controllers\EventImagesController::class, 'upload']);
                Route::delete('/documents/upload/revert', [App\Http\Controllers\EventDocumentsController::class, 'undoUpload']);
                Route::post('/documents/upload', [App\Http\Controllers\EventDocumentsController::class, 'upload']);
                Route::get('/find{event?}', [App\Http\Controllers\EventsController::class, 'findEvent']);
                Route::get('/create', [App\Http\Controllers\EventsController::class, 'create'])->name('create');
                Route::post('', [App\Http\Controllers\EventsController::class, 'store'])->name('store');
                Route::get('', [App\Http\Controllers\EventsController::class, 'index'])->name('index');
               
                Route::group([
                        'prefix' => '/{event_slug}',
                        'where' => ['event_slug' => '^[a-zA-Z0-9-_]{2,255}$'],], 
                    function () {
                        // Event
                        // --> /e/{event_slug}

                        Route::get('/edit', [App\Http\Controllers\EventsController::class, 'edit'])->name('edit');
                        Route::patch('', [App\Http\Controllers\EventsController::class, 'update'])->name('update');
                        Route::delete('', [App\Http\Controllers\EventsController::class, 'destroy'])->name('destroy');
                        Route::get('/{newEvent?}', [App\Http\Controllers\EventsController::class, 'show'])->name('show')->where(['newEvent' => '^([1-9][0-9]*)$']);

                        // Event Images
                        Route::group([
                                'as' => 'image.',
                                'prefix' => '/images',],
                            function () {
                            // Event Images
                            // --> /e/{event_slug}/images

                            Route::get('/create', [App\Http\Controllers\EventImagesController::class, 'create'])->name('create');
                            Route::get('/createCaption', [App\Http\Controllers\EventImagesController::class, 'createCaption'])->name('createCaption');
                            Route::post('/storeImages', [App\Http\Controllers\EventImagesController::class, 'store'])->name('store');
                            Route::post('/storeCaptions', [App\Http\Controllers\EventImagesController::class, 'storeCaption'])->name('storeCaption');
                            Route::get('', [App\Http\Controllers\EventImagesController::class, 'index'])->name('index');


                            Route::group([
                                    'prefix' => '/{eventImage_slug}',
                                    'where' => ['eventImage_slug' => '^[a-zA-Z0-9-_]{2,255}$'],], 
                                function () {
                                // Event Images
                                // --> /e/{event_slug}/images/{eventImage_slug}

                                Route::get('/edit', [App\Http\Controllers\EventImagesController::class, 'edit'])->name('edit');
                                Route::patch('', [App\Http\Controllers\EventImagesController::class, 'update'])->name('update');
                                Route::delete('', [App\Http\Controllers\EventImagesController::class, 'destroy'])->name('destroy');
                                Route::get('', [App\Http\Controllers\EventImagesController::class, 'show'])->name('show');
                            });
                        });

                        // Event Documents {/document}
                        Route::group([
                                'as' => 'document.',
                                'prefix' => '/document/{document_id}',
                                'where' => ['document_id' => '^([1-9][0-9]*)$'],],
                            function() {
                            // Event Documents
                            // --> /e/{event_slug}/document/{document_id}

                                    Route::delete('', [App\Http\Controllers\EventDocumentsController::class, 'destroy'])->name('destroy');
                                    Route::get('/download', [App\Http\Controllers\EventDocumentsController::class, 'downloadDocument'])->name('download');
                        });

                        // Event Documents {/documents}
                        Route::group([
                                'as' => 'document.',
                                'prefix' => '/documents',],
                            function() {
                            // Event Documents
                            // --> /e/{event_slug}/documents

                                    Route::get('/create', [App\Http\Controllers\EventDocumentsController::class, 'create'])->name('create');
                                    Route::get('/download', [App\Http\Controllers\EventDocumentsController::class, 'downloadAllDocument'])->name('downloadAll');
                                    Route::get('', [App\Http\Controllers\EventDocumentsController::class, 'index'])->name('index');
                                    Route::post('', [App\Http\Controllers\EventDocumentsController::class, 'store'])->name('store');
                                    
                        });

                });
        });

        // Student Accomplishments
        Route::group([
                'as' => 'studentAccomplishment.',
                'prefix' => '/s/accomplishments',],
            function () {
            // Student Accomplishment
            // --> /s/accomplishments

                Route::delete('/upload/revert', [App\Http\Controllers\StudentAccomplishmentsController::class, 'undoUpload']);
                Route::get('/create', [App\Http\Controllers\StudentAccomplishmentsController::class, 'create'])->name('create');
                Route::post('/upload', [App\Http\Controllers\StudentAccomplishmentsController::class, 'upload']);
                Route::get('', [App\Http\Controllers\StudentAccomplishmentsController::class, 'index'])->name('index');
                Route::post('', [App\Http\Controllers\StudentAccomplishmentsController::class, 'store']);
        });

        Route::group([
                'as' => 'studentAccomplishment.',
                'prefix' => '/s/accomplishment/{accomplishmentUUID}',
                'where' => ['accomplishmentUUID' => '^[a-zA-Z0-9-]{36}$'],],
            function () {
            // Student Accomplishment
            // --> /s/accomplishment/{accomplishmentUUID}

                Route::get('/final', [App\Http\Controllers\StudentAccomplishmentsController::class, 'finalReview'])->name('finalReview');
                Route::post('/final', [App\Http\Controllers\StudentAccomplishmentsController::class, 'approveSubmission'])->name('approveSubmission');
                Route::get('/review', [App\Http\Controllers\StudentAccomplishmentsController::class, 'initialReview'])->name('review');
                Route::post('', [App\Http\Controllers\StudentAccomplishmentsController::class, 'getSubmissionDecision'])->name('submissionDecision');
                Route::get('/{newAccomplishment?}', [App\Http\Controllers\StudentAccomplishmentsController::class, 'show'])->name('show');   
        });

        Route::group([
                'as' => 'notification.',
                'prefix' => '/u/notification/{notification_id}',
                'where' => ['notification_id' => '^([1-9][0-9]*)$'],],
            function () {
            // User Notification
            // --> /u/notification/{notification_id}

                Route::post('', [App\Http\Controllers\NotificationsController::class, 'markAsRead'])->name('markAsRead'); 
        });

        // User Notification Routes
        Route::group([
                'as' => 'notifications.',
                'prefix' => '/u/notifications',],
            function () {
            // User Notification
            // --> /u/notifications

                Route::post('/all', [App\Http\Controllers\NotificationsController::class, 'markAllAsRead'])->middleware('auth')->name('markAllAsRead');
                Route::get('', [App\Http\Controllers\NotificationsController::class, 'show'])->middleware('auth')->name('show');
        });

    });


    
    






//Notice
    // Route::get('/n/{notice_uuid}', [App\Http\Controllers\MeetingNoticesController::class, 'show'])->where(['notice_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth')->name('meetingNotice.show');
    // Route::get('/n/{notice_uuid}/edit', [App\Http\Controllers\MeetingNoticesController::class, 'edit'])->where(['notice_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth');//->name('show');
    // Route::patch('/n/{notice_uuid}', [App\Http\Controllers\MeetingNoticesController::class, 'update'])->where(['notice_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth');
    // Route::delete('/n/{notice_uuid}', [App\Http\Controllers\MeetingNoticesController::class, 'destroy'])->where(['notice_uuid' => '^[a-zA-Z0-9-]{36}$'])->middleware('auth');
    // Route::get('/n', [App\Http\Controllers\MeetingNoticesController::class, 'index'])->name('meetingnotices.index')->middleware('auth');
    // Route::get('/n/create', [App\Http\Controllers\MeetingNoticesController::class, 'create'])->middleware('auth');
    // Route::post('/n', [App\Http\Controllers\MeetingNoticesController::class, 'store'])->middleware('auth');

    // Route::get('/o/documents/create', [App\Http\Controllers\DocumentManagementController::class, 'create'])->middleware('auth');
    // Route::post('/o/documents', [App\Http\Controllers\DocumentManagementController::class, 'store'])->middleware('auth');



