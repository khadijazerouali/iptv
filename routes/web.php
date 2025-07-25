<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route publique pour les détails des produits
Route::get('/product/{slug}', [App\Http\Controllers\Public\ProductController::class, 'show'])->name('product.details');

// Route spécifique pour le dashboard (utilise UUID)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/product/{productUuid}', [DashboardController::class, 'showProduct'])->name('dashboard.product.details');
});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/dashboard/update-profile', [DashboardController::class, 'updateProfile'])->name('dashboard.updateProfile');
    Route::get('/dashboard/invoice/{subscription}/download', [DashboardController::class, 'downloadInvoice'])->name('dashboard.downloadInvoice');
    Route::post('/dashboard/support-ticket', [DashboardController::class, 'createSupportTicket'])->name('dashboard.createSupportTicket');
    Route::get('/order/{subscriptionUuid}', [DashboardController::class, 'showOrderDetails'])->name('order.details');


    // Routes Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::view('dashboard', 'admin.dashboard')->name('dashboard');
        Route::view('products', 'admin.products')->name('products');
        Route::view('contacts', 'admin.contacts')->name('contacts');
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::view('support', 'admin.support')->name('support');
        Route::view('orders', 'admin.orders')->name('orders');
        Route::view('categories', 'admin.categories')->name('categories');
        Route::view('device-types', 'admin.device-types')->name('device-types');
        Route::view('application-types', 'admin.application-types')->name('application-types');
        
        // API Routes pour les utilisateurs
        Route::put('users/{id}/role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    });
    
    // Route pour télécharger les factures (admin)
    Route::get('/admin/orders/{subscriptionUuid}/download', [DashboardController::class, 'downloadInvoice'])->name('admin.orders.download');

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
