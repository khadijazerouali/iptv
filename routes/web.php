<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
Route::middleware(['auth'])->group(function () {

    Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
