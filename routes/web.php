<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LandingMediaController;

// Registrasi rute autentikasi (login, register, logout)
Auth::routes();

// Override logout route - redirect to home page instead of login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute utama ke landing page
Route::get('/', [HomeController::class, 'root'])->name('root');
Route::get('/landing/video', [LandingMediaController::class, 'video'])->name('landing.video');

// Public route: daftar barang peminjaman dapat dilihat tanpa login
Route::get('/assets/loanable', [AssetController::class, 'loanable'])
    ->middleware('page.enabled:assets_loanable')
    ->name('assets.loanable');

// Public route: bukti peminjaman dapat dilihat dari halaman utama tanpa login
Route::get('/loans/receipt/{batch}', [LoanController::class, 'receipt'])
    ->middleware('page.enabled:loans')
    ->name('loans.receipt');

Route::middleware('auth')->group(function () {
    // Halaman dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart/petugas-monthly', [HomeController::class, 'petugasMonthlyChart'])->name('dashboard.chart.petugas-monthly');
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    // Backward compatibility
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Routes aset
    Route::get('/assets/export', [AssetController::class, 'exportExcel'])->name('assets.export');
    Route::get('/assets/import', [AssetController::class, 'importForm'])->name('assets.import.form');
    Route::post('/assets/import', [AssetController::class, 'import'])->name('assets.import');
    Route::get('/assets/template', [AssetController::class, 'exportTemplate'])->name('assets.template');
    Route::delete('/assets/{asset}/photo', [AssetController::class, 'destroyPhoto'])->name('assets.photo.destroy');
    Route::resource('assets', AssetController::class)->middleware('page.enabled:assets_inventory');

    // Routes peminjaman (operasional)
    Route::get('/loans', [LoanController::class, 'index'])->middleware('page.enabled:loans')->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->middleware('page.enabled:loans')->name('loans.create');
    Route::post('/loans/batch', [LoanController::class, 'storeBatch'])->middleware('page.enabled:loans')->name('loans.store.batch');
    Route::delete('/loans/{loan}', [LoanController::class, 'destroy'])->middleware('page.enabled:loans')->name('loans.destroy');
    Route::get('/loans/{loan}/return', [LoanController::class, 'returnForm'])->middleware('page.enabled:loans')->name('loans.return.form');
    Route::put('/loans/{loan}/return', [LoanController::class, 'returnUpdate'])->middleware('page.enabled:loans')->name('loans.return.update');
    Route::get('/loans/{loan}/return-receipt', [LoanController::class, 'returnReceipt'])->middleware('page.enabled:loans')->name('loans.return.receipt');

    // Routes laporan (gabungan)
    Route::get('/reports', [ReportsController::class, 'index'])->middleware('page.enabled:reports')->name('reports.index');
    Route::get('/reports/pdf', [ReportsController::class, 'pdf'])->middleware('page.enabled:reports')->name('reports.pdf');
    Route::get('/reports/excel', [ReportsController::class, 'excel'])->middleware('page.enabled:reports')->name('reports.excel');
    // Backward compatibility
    Route::get('/reports/loans', [ReportsController::class, 'loans'])->middleware('page.enabled:reports')->name('reports.loans');
    Route::get('/reports/loans/pdf', [ReportsController::class, 'loansPdf'])->middleware('page.enabled:reports')->name('reports.loans.pdf');
    Route::get('/reports/loans/excel', [ReportsController::class, 'loansExcel'])->middleware('page.enabled:reports')->name('reports.loans.excel');
    Route::get('/reports/returns', [ReportsController::class, 'returns'])->middleware('page.enabled:reports')->name('reports.returns');
    Route::get('/reports/returns/pdf', [ReportsController::class, 'returnsPdf'])->middleware('page.enabled:reports')->name('reports.returns.pdf');
    Route::get('/reports/returns/excel', [ReportsController::class, 'returnsExcel'])->middleware('page.enabled:reports')->name('reports.returns.excel');

    // Routes administrasi anggota
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->middleware('page.enabled:users')->name('users.reset');
    Route::delete('/users/{user}/photo', [UserController::class, 'destroyPhoto'])->middleware('page.enabled:users')->name('users.photo.destroy');
    Route::resource('users', UserController::class)->except('show')->middleware('page.enabled:users');

    Route::get('/settings/admin-menu', [SettingController::class, 'adminMenu'])
        ->middleware('role:super_admin')
        ->name('settings.admin-menu');
    Route::post('/settings/admin-menu', [SettingController::class, 'updateAdminMenu'])
        ->middleware('role:super_admin')
        ->name('settings.admin-menu.update');
    Route::post('/settings/admin-menu/logs/clear', [SettingController::class, 'clearAdminMenuLogs'])
        ->middleware('role:super_admin')
        ->name('settings.admin-menu.logs.clear');
    Route::get('/settings/admin-menu/logs/export', [SettingController::class, 'exportAdminMenuLogs'])
        ->middleware('role:super_admin')
        ->name('settings.admin-menu.logs.export');
});

// Jika kamu membutuhkan route dinamis untuk menangani URL lainnya
Route::get('{any}', [HomeController::class, 'index'])->name('index');
