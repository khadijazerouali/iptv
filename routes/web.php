<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route publique pour les détails des produits
// Route::get('/product/{productUuid}', [DashboardController::class, 'showProduct'])->name('product.details');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/dashboard/update-profile', [DashboardController::class, 'updateProfile'])->name('dashboard.updateProfile');
    Route::get('/dashboard/invoice/{subscription}/download', [DashboardController::class, 'downloadInvoice'])->name('dashboard.downloadInvoice');
    Route::post('/dashboard/support-ticket', [DashboardController::class, 'createSupportTicket'])->name('dashboard.createSupportTicket');
    Route::get('/order/{subscriptionUuid}', [DashboardController::class, 'showOrderDetails'])->name('order.details');


    // Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('admin/products', 'admin.products')->name('admin.products');
    Route::view('admin/contacts', 'admin.contacts')->name('admin.contacts');
    Route::view('admin/users', 'admin.users')->name('admin.users');
    Route::view('admin/support', 'admin.support')->name('admin.support');
    Route::view('admin/orders', 'admin.orders')->name('admin.orders');
    Route::view('admin/categories', 'admin.categories')->name('admin.categories');
    Route::view('admin/device-types', 'admin.device-types')->name('admin.device-types');
    Route::view('admin/application-types', 'admin.application-types')->name('admin.application-types');

});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/success', function () {
    return view('pages.success');
})->name('success');



require __DIR__.'/auth.php';
