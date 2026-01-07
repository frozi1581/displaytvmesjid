<?php

use App\Http\Controllers\Users\PlayerController as UsersPlayerController;
use App\Http\Controllers\Users\PlayerControllerDev as UsersPlayerDevController;
use App\Http\Controllers\Users\ConfigController as UsersConfigController;
use App\Http\Controllers\Users\HomeController as UsersHomeController;
use App\Http\Controllers\Users\ProfileController as UsersProfileController;
use App\Http\Controllers\Users\MarqueeController as UsersMarqueeController;
use App\Http\Controllers\Users\TransactionController as UsersTransactionController;
use App\Http\Controllers\Users\LectureController as UsersLectureController;
use App\Http\Controllers\Users\FileController as UsersFileController;
use App\Http\Controllers\Users\TemplateController as UsersTemplateController;
use App\Http\Controllers\Users\Configs\PrayerController as UsersConfigPrayerController;
use App\Http\Controllers\Users\Configs\PlayerController as UsersConfigPlayerController;
use App\Http\Controllers\CustomAPI;
use Illuminate\Support\Facades\Artisan;
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

Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/refresh', [\App\Http\Controllers\CustomDataAPIController::class, 'index']);
Route::get('/refresh-status', [\App\Http\Controllers\CustomDataAPIController::class, 'updateRefreshStatus']);
Route::get('/debug/ownership', [UsersFileController::class, 'debugOwnership'])->name('debug.ownership');

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
});

Route::get('/initialize', function () {
    Artisan::call('storage:link');
});

Route::get('/template', function () {
    return view('users.templates.index');
});

Route::get('/file', function () {
    return view('users.files.index');
});

Auth::routes();

Route::get('/home', [UsersHomeController::class, 'index'])->name('home');

Route::get('/player/{token}', [UsersPlayerController::class, 'index'])->name('player');
Route::get('/playerdev/{token}', [UsersPlayerDevController::class, 'index'])->name('playerdev');
Route::get('/reminderpraywa/{token}', [\App\Http\Controllers\Users\Configs\ReminderPrayWA::class, 'index'])->name('reminderpraywa');

Route::prefix('/user')->middleware('auth')->group(function() {

    Route::prefix('/config')->name('config.')->group(function () {
        Route::get('', [UsersConfigController::class, 'index'])->name('index');

        Route::prefix('/prayer')->name('prayer.')->group(function () {
            Route::get('', [UsersConfigPrayerController::class, 'index'])->name('index');
            Route::get('/{prayer}', [UsersConfigPrayerController::class, 'edit'])->name('edit');
            Route::post('/{configPrayer}', [UsersConfigPrayerController::class, 'update'])->name('update');
        });

        Route::prefix('/player')->name('player.')->group(function () {
            Route::get('', [UsersConfigPlayerController::class, 'index'])->name('index');
            Route::get('/edit', [UsersConfigPlayerController::class, 'edit'])->name('edit');
            Route::get('/main', [UsersConfigPlayerController::class, 'main'])->name('main');
            Route::get('/transaction', [UsersConfigPlayerController::class, 'transaction'])->name('transaction');
            Route::get('/lecture', [UsersConfigPlayerController::class, 'lecture'])->name('lecture');
            Route::get('/imsak', [UsersConfigPlayerController::class, 'imsak'])->name('imsak');
            Route::get('/syuruq', [UsersConfigPlayerController::class, 'syuruq'])->name('syuruq');

            Route::post('/upload/{key}', [UsersConfigPlayerController::class, 'upload'])->name('upload');
            Route::post('/update/{key}', [UsersConfigPlayerController::class, 'update'])->name('update');
            Route::post('/transaction/{key}', [UsersConfigPlayerController::class, 'transactionUpdate'])->name('transaction.update');
            Route::post('/lecture/{key}', [UsersConfigPlayerController::class, 'lectureUpdate'])->name('lecture.update');
            Route::post('/imsak/{key}', [UsersConfigPlayerController::class, 'imsakUpdate'])->name('imsak.update');
            Route::post('/syuruq/{key}', [UsersConfigPlayerController::class, 'syuruqUpdate'])->name('syuruq.update');
        });
    });

    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('', [UsersProfileController::class, 'index'])->name('index');
        Route::post('/information', [UsersProfileController::class, 'information'])->name('information');
        Route::post('/additional', [UsersProfileController::class, 'additional'])->name('additional');
        Route::post('/security', [UsersProfileController::class, 'security'])->name('security');
        Route::post('/password', [UsersProfileController::class, 'password'])->name('password');
    });

    Route::prefix('/marquee')->name('marquee.')->group(function () {
        Route::get('', [UsersMarqueeController::class, 'index'])->name('index');
        Route::get('/create', [UsersMarqueeController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UsersMarqueeController::class, 'edit'])->whereNumber('id')->name('edit');
        Route::get('/{id}', [UsersMarqueeController::class, 'show'])->whereNumber('id')->name('show');
        Route::post('', [UsersMarqueeController::class, 'store'])->name('store');
        Route::put('/{id}', [UsersMarqueeController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/{id}', [UsersMarqueeController::class, 'destroy'])->whereNumber('id')->name('destroy');
    });

    Route::prefix('/transaction')->name('transaction.')->group(function () {
        Route::get('', [UsersTransactionController::class, 'index'])->name('index');
        Route::get('/create', [UsersTransactionController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UsersTransactionController::class, 'edit'])->whereNumber('id')->name('edit');
        Route::get('/{id}', [UsersTransactionController::class, 'show'])->whereNumber('id')->name('show');
        Route::post('', [UsersTransactionController::class, 'store'])->name('store');
        Route::put('/{id}', [UsersTransactionController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/{id}', [UsersTransactionController::class, 'destroy'])->whereNumber('id')->name('destroy');
    });

    Route::prefix('/lecture')->name('lecture.')->group(function () {
        Route::get('', [UsersLectureController::class, 'index'])->name('index');
        Route::get('/create', [UsersLectureController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UsersLectureController::class, 'edit'])->whereNumber('id')->name('edit');
        Route::get('/{id}', [UsersLectureController::class, 'show'])->whereNumber('id')->name('show');
        Route::post('', [UsersLectureController::class, 'store'])->name('show');
        Route::put('/{id}', [UsersLectureController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/{id}', [UsersLectureController::class, 'destroy'])->whereNumber('id')->name('destroy');
    });

    // ========================================
    // ENHANCED FILE/MEDIA MANAGEMENT ROUTES
    // ========================================
    Route::prefix('/file')->name('file.')->group(function () {
        // ===== MAIN CRUD ROUTES =====
        Route::get('', [UsersFileController::class, 'index'])->name('index');
        Route::get('/create', [UsersFileController::class, 'create'])->name('create');
        Route::post('', [UsersFileController::class, 'store'])->name('store');
        Route::get('/{id}', [UsersFileController::class, 'show'])->whereNumber('id')->name('show');
        Route::delete('/{id}', [UsersFileController::class, 'destroy'])->whereNumber('id')->name('destroy');

        // ===== SCHEDULE MANAGEMENT ROUTES =====
        Route::get('/{id}/schedule', [UsersFileController::class, 'getSchedule'])->whereNumber('id')->name('schedule.show');
        Route::put('/{id}/schedule', [UsersFileController::class, 'updateSchedule'])->whereNumber('id')->name('schedule.update');

        // ===== ARCHIVE/RESTORE MANAGEMENT ROUTES =====
        Route::post('/{id}/archive', [UsersFileController::class, 'archive'])->whereNumber('id')->name('archive.single');
        Route::post('/{id}/restore', [UsersFileController::class, 'restore'])->whereNumber('id')->name('restore.single');

        // ===== STATUS MANAGEMENT ROUTES =====
        Route::patch('/{id}/status', [UsersFileController::class, 'updateStatus'])->whereNumber('id')->name('status.update');
        Route::get('/status/check', [UsersFileController::class, 'checkStatuses'])->name('status.check');

        // ===== FILTER ROUTES =====
        Route::get('/filter/archived', [UsersFileController::class, 'archived'])->name('archived');
        Route::get('/filter/active', [UsersFileController::class, 'active'])->name('active');
        Route::get('/filter/scheduled', [UsersFileController::class, 'scheduled'])->name('scheduled');
        Route::get('/filter/expired', [UsersFileController::class, 'expired'])->name('expired');

        // ===== BULK OPERATIONS ROUTES =====
        Route::post('/bulk/archive', [UsersFileController::class, 'bulkArchive'])->name('bulk.archive');
        Route::post('/bulk/restore', [UsersFileController::class, 'bulkRestore'])->name('bulk.restore');
        Route::delete('/bulk/delete', [UsersFileController::class, 'bulkDelete'])->name('bulk.delete');

        // ========================================
        // AJAX/API ROUTES (These match your JavaScript calls)
        // ========================================

        // Schedule management via AJAX
        Route::post('/ajax/update-schedule', [UsersFileController::class, 'apiUpdateSchedule'])->name('ajax.update-schedule');

        // Archive/Restore via AJAX
        Route::post('/ajax/archive', [UsersFileController::class, 'apiArchive'])->name('ajax.archive');
        Route::post('/ajax/restore', [UsersFileController::class, 'apiRestore'])->name('ajax.restore');

        // Delete via AJAX
        Route::delete('/ajax/delete', [UsersFileController::class, 'apiDelete'])->name('ajax.delete');

        // Status management via AJAX
        Route::post('/ajax/status/update', [UsersFileController::class, 'updateStatus'])->name('ajax.status.update');

        // Bulk operations via AJAX
        Route::post('/ajax/bulk/archive', [UsersFileController::class, 'apiBulkArchive'])->name('ajax.bulk.archive');
        Route::post('/ajax/bulk/restore', [UsersFileController::class, 'apiBulkRestore'])->name('ajax.bulk.restore');
        Route::delete('/ajax/bulk/delete', [UsersFileController::class, 'apiBulkDelete'])->name('ajax.bulk.delete');

        // Utility AJAX routes
        Route::get('/ajax/stats', [UsersFileController::class, 'apiStats'])->name('ajax.stats');
        Route::get('/ajax/list', [UsersFileController::class, 'apiList'])->name('ajax.list');
        Route::post('/ajax/search', [UsersFileController::class, 'apiSearch'])->name('ajax.search');
        Route::post('/ajax/validate', [UsersFileController::class, 'apiValidateFile'])->name('ajax.validate');
    });

    Route::prefix('/template')->name('template.')->group(function () {
        Route::get('', [UsersTemplateController::class, 'index'])->name('index');
        Route::post('', [UsersTemplateController::class, 'pick'])->name('pick');
    });
});

// ========================================
// PUBLIC API ROUTES (for display/player - no authentication required)
// ========================================
Route::prefix('/api')->name('api.')->group(function() {
    // Media endpoints for display/player
    Route::get('/media/{token}', [UsersFileController::class, 'getActiveMedia'])->name('media.active');
    Route::get('/background/{token}', [UsersFileController::class, 'getCurrentBackground'])->name('media.background');
    Route::get('/images/{token}', [UsersFileController::class, 'getCurrentImages'])->name('media.images');
    Route::get('/videos/{token}', [UsersFileController::class, 'getCurrentVideos'])->name('media.videos');

    // Status check for display
    Route::get('/status/{token}', [UsersFileController::class, 'getDisplayStatus'])->name('media.status');
});

// ========================================
// CRON JOB ROUTES (should be protected in production with middleware or IP restriction)
// ========================================
Route::prefix('/cron')->name('cron.')->group(function() {
    // File status updates
    Route::get('/update-file-statuses', [UsersFileController::class, 'cronUpdateStatuses'])->name('file.statuses');

    // Auto archive expired files
    Route::get('/auto-archive', [UsersFileController::class, 'cronAutoArchive'])->name('file.archive');

    // Clean up old archived files
    Route::get('/cleanup-archives', [UsersFileController::class, 'cronCleanupArchives'])->name('file.cleanup');
});

// ========================================
// DISPLAY/PLAYER ROUTES (public access for TV displays)
// ========================================
Route::prefix('/display')->name('display.')->group(function() {
    // Get active media for display
    Route::get('/{token}/media', [UsersFileController::class, 'getActiveMedia'])->name('media');

    // Get specific media types
    Route::get('/{token}/background', [UsersFileController::class, 'getCurrentBackground'])->name('background');
    Route::get('/{token}/images', [UsersFileController::class, 'getCurrentImages'])->name('images');
    Route::get('/{token}/videos', [UsersFileController::class, 'getCurrentVideos'])->name('videos');

    // Display status for debugging
    Route::get('/{token}/status', [UsersFileController::class, 'getDisplayStatus'])->name('status');

    // Refresh endpoint
    Route::post('/{token}/refresh', [UsersFileController::class, 'triggerRefresh'])->name('refresh');
});

// ========================================
// WEBHOOK ROUTES (for external integrations)
// ========================================
Route::prefix('/webhook')->name('webhook.')->middleware(['throttle:60,1'])->group(function() {
    // File upload notifications
    Route::post('/file-uploaded', [UsersFileController::class, 'webhookFileUploaded'])->name('file.uploaded');

    // Display status notifications
    Route::post('/display-status', [UsersFileController::class, 'webhookDisplayStatus'])->name('display.status');
});

// ========================================
// ADMIN ROUTES (if needed for super admin access)
// ========================================
Route::prefix('/admin')->middleware(['auth', 'admin'])->name('admin.')->group(function() {
    // Global file management
    Route::get('/files', [UsersFileController::class, 'adminIndex'])->name('files.index');
    Route::get('/files/stats', [UsersFileController::class, 'adminStats'])->name('files.stats');
    Route::post('/files/cleanup', [UsersFileController::class, 'adminCleanup'])->name('files.cleanup');
});

// ========================================
// LEGACY COMPATIBILITY ROUTES (if needed for old code)
// ========================================
Route::prefix('/legacy')->name('legacy.')->group(function() {
    // Old update background start method
    Route::post('/file/{id}/update-bg-start', [UsersFileController::class, 'updateBGStart'])->whereNumber('id')->name('file.update-bg-start');
});
