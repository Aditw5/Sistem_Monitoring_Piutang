<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoresponderController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DashController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\Halaman;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PhonebookController;
use App\Http\Controllers\PiutangMitra;
use App\Http\Controllers\PiutangMitraController;
use App\Http\Controllers\PluginsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SingleSender;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [HalamanController::class, 'dashboard'])->name('dashboard.dashboard')->middleware('auth');

Route::get('storage', [DashController::class, 'storage'])->name('storage');

// Route::resource('mitra', MitraController::class)->name('mitra');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
     Route::get('/', [HalamanController::class, 'dashboard'])->name('dashboard.dashboard');

    });

});

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
     Route::get('/', [ProfileController::class, 'profile'])->name('profile.profile');

    });

});

Route::prefix('laporan')->middleware('auth')->group(function () {
    Route::prefix('laporan')->group(function () {
     Route::get('/', [LaporanController::class, 'laporan'])->name('laporan.laporan');
     Route::post('/', [LaporanController::class, 'laporan'])->name('laporan.laporan.ajax')->withoutMiddleware(VerifyCsrfToken::class);
     
    });

});

Route::prefix('piutang')->middleware('auth')->group(function () {
    Route::prefix('mitra')->group(function () {
        Route::get('/', [PiutangMitraController::class, 'piutang'])->name('piutang.piutang');
        Route::post('/', [PiutangMitraController::class, 'piutang'])->name('piutang.piutang.ajax')->withoutMiddleware(VerifyCsrfToken::class);
        Route::post('/store', [PiutangMitraController::class, 'piutang_store'])->name('piutang.piutang.store')->middleware('isdemo');
        Route::get('/edit/{id}', [PiutangMitraController::class, 'piutang_edit'])->name('piutang.piutang.edit');
        Route::post('/update', [PiutangMitraController::class, 'piutang_update'])->name('piutang.piutang.update')->middleware('isdemo');
    });
});

Route::prefix('mitra')->middleware('auth')->group(function () {
    Route::prefix('mitra')->group(function () {
        Route::get('/', [MitraController::class, 'mitra'])->name('mitra.mitra');
        Route::post('/', [MitraController::class, 'mitra'])->name('mitra.mitra.ajax')->withoutMiddleware(VerifyCsrfToken::class);
        Route::post('/store', [MitraController::class, 'mitra_store'])->name('mitra.mitra.store')->middleware('isdemo');
        Route::get('/edit/{id}', [MitraController::class, 'mitra_edit'])->name('mitra.mitra.edit');
        Route::post('/update', [MitraController::class, 'mitra_update'])->name('mitra.mitra.update')->middleware('isdemo');
        Route::post('/delete/{id}', [MitraController::class, 'mitra_delete'])->name('mitra.mitra.delete')->middleware('isdemo');
    });
});


Route::prefix('/')->middleware(['auth'])->group(function () {
    Route::prefix('ajax')->withoutMiddleware(VerifyCsrfToken::class)->group(function () {
        Route::prefix('device')->group(function () {
            Route::post('main', [DashController::class, 'ajax_main_device'])->name('ajax.main_device');
            Route::post('settings', [DashController::class, 'ajax_device_settings'])->name('ajax.device.settings');
            Route::post('change-main', [DashController::class, 'ajax_change_device'])->name('ajax.change_device');
            Route::get('generate-apikey', [DashController::class, 'ajax_generate_key'])->name('ajax.generate_key');
        });
    });

    Route::get('dashboard', [DashController::class, 'index'])->name('dashboard');
    Route::post('dashboard', [DashController::class, 'index'])->name('dashboard')->withoutMiddleware(VerifyCsrfToken::class);
    Route::get('files', [DashController::class, 'files'])->name('files');
    Route::get('halaman', [DashController::class, 'halaman'])->name('dashboard.halaman');

    Route::prefix('device')->group(function () {
        Route::get('id/{id}', [DeviceController::class, 'index'])->name('device.detail');
        Route::post('delete', [DashController::class, 'device_delete'])->name('device.delete');
        Route::post('store', [DashController::class, 'device_store'])->name('device.store');
        Route::post('device-settings-update', [DashController::class, 'device_settings_update'])->name('device.settings.update');
    });

    Route::prefix('responder')->group((function () {
        Route::get('/', [AutoresponderController::class, 'index'])->name('responder');
        Route::post('/', [AutoresponderController::class, 'index'])->name('responder')->withoutMiddleware(VerifyCsrfToken::class);
        Route::get('/detail/{id}', [AutoresponderController::class, 'detail'])->name('responder.detail');
        Route::post('/delete', [AutoresponderController::class, 'delete'])->name('responder.delete');
        Route::post('/store', [AutoresponderController::class, 'store'])->name('responder.store');
        Route::post('/upadte/{id}', [AutoresponderController::class, 'update'])->name('responder.update');
        Route::post('/status', [AutoresponderController::class, 'status'])->name('responder.status');
    }));

    Route::prefix('message')->group(function () {
        Route::get('/', [SingleSender::class, 'index'])->name('single');
        Route::post('/store', [SingleSender::class, 'store'])->name('single.store');
    });

    Route::prefix('phonebook')->group(function () {
        Route::get('/', [PhonebookController::class, 'index'])->name('phonebook');
        Route::get('/delete/{id}', [PhonebookController::class, 'label_delete'])->name('phonebook.delete');
        Route::post('/ajax/storelabels', [PhonebookController::class, 'ajax_label_store'])->name('phonebook.ajax.label.store')->withoutMiddleware(VerifyCsrfToken::class);

        Route::prefix('contacts/{id}')->group(function () {
            Route::get('/', [PhonebookController::class, 'contacts'])->name('phonebook.contacts.index');
            Route::post('/', [PhonebookController::class, 'contacts'])->name('phonebook.contacts.ajax')->withoutMiddleware(VerifyCsrfToken::class);
            Route::post('/store', [PhonebookController::class, 'contacts_store'])->name('phonebook.contacts.store');
            Route::post('/delete', [PhonebookController::class, 'contacts_delete'])->name('phonebook.contacts.delete');

            Route::get('/export', [PhonebookController::class, 'contacts_export'])->name('phonebook.contacts.export');
            Route::post('/import', [PhonebookController::class, 'contacts_import'])->name('phonebook.contacts.import');
            Route::get('/fetch-group', [PhonebookController::class, 'fetch_group'])->name('phonebook.contacts.fetchgroup');
        });
    });


    Route::prefix('campaigns')->group(function () {
        Route::get('/', [CampaignsController::class, 'index'])->name('campaigns.index');
        Route::post('/', [CampaignsController::class, 'index'])->name('campaigns.ajax')->withoutMiddleware(VerifyCsrfToken::class);
        Route::get('/detail/{id}', [CampaignsController::class, 'detail'])->name('campaigns.detail');
        Route::post('/detail/{id}', [CampaignsController::class, 'detail'])->name('campaigns.detail.ajax')->withoutMiddleware(VerifyCsrfToken::class);
        Route::post('/store', [CampaignsController::class, 'store'])->name('campaigns.store');
        Route::post('/delete', [CampaignsController::class, 'delete'])->name('campaigns.delete');

        Route::post('/ajax/changestatus', [CampaignsController::class, 'ajax_change_status'])->name('campaigns.ajax.changestatus');
    });

    Route::prefix('apidocs')->group(function () {
        Route::get('/', [ApiController::class, 'index'])->name('apidocs');
    });

    Route::prefix('boradcast')->group(function () {
        Route::get('/', [BroadcastController::class, 'index'])->name('broadcast');
    });

    Route::prefix('plugins')->group(function () {
        Route::get('/', [PluginsController::class, 'index'])->name('plugins');
        Route::post('/', [PluginsController::class, 'index'])->name('plugins.ajax')->withoutMiddleware(VerifyCsrfToken::class);
        Route::post('/change', [PluginsController::class, 'change'])->name('plugins.change');
    });

    Route::prefix('admin')->middleware('auth')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [AdminController::class, 'users'])->name('admin.users');
            Route::post('/', [AdminController::class, 'users'])->name('admin.users.ajax')->withoutMiddleware(VerifyCsrfToken::class);
            Route::post('/store', [AdminController::class, 'users_store'])->name('admin.users.store')->middleware('isdemo');
            Route::get('/edit/{id}', [AdminController::class, 'users_edit'])->name('admin.users.edit');
            Route::post('/update', [AdminController::class, 'users_update'])->name('admin.users.update')->middleware('isdemo');
            Route::post('/delete/{id}', [AdminController::class, 'users_delete'])->name('admin.users.delete')->middleware('isdemo');
        });

        // Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        // Route::post('/settings', [AdminController::class, 'settings'])->name('admin.settings.update');
    });
});

require_once(__DIR__ . '/files.php');
