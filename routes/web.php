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
        // Dashboard principal avec données dynamiques
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Gestion des produits avec données dynamiques
        Route::get('products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products');
        Route::get('products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
        Route::get('products/{uuid}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
        Route::get('products/{uuid}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');
        Route::post('products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
        Route::put('products/{uuid}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{uuid}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
        
        // Gestion des types d'appareils avec données dynamiques
        Route::get('device-types', [App\Http\Controllers\Admin\DeviceTypeController::class, 'index'])->name('device-types');
        Route::get('device-types/all', [App\Http\Controllers\Admin\DeviceTypeController::class, 'getAll'])->name('device-types.all');
        Route::get('device-types/{uuid}', [App\Http\Controllers\Admin\DeviceTypeController::class, 'show'])->name('device-types.show')->where('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        Route::post('device-types', [App\Http\Controllers\Admin\DeviceTypeController::class, 'store'])->name('device-types.store');
        Route::put('device-types/{uuid}', [App\Http\Controllers\Admin\DeviceTypeController::class, 'update'])->name('device-types.update')->where('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        Route::delete('device-types/{uuid}', [App\Http\Controllers\Admin\DeviceTypeController::class, 'destroy'])->name('device-types.destroy')->where('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        
        // Gestion des types d'applications avec données dynamiques
        Route::get('application-types', [App\Http\Controllers\Admin\ApplicationTypeController::class, 'index'])->name('application-types');
        Route::get('application-types/{uuid}', [App\Http\Controllers\Admin\ApplicationTypeController::class, 'show'])->name('application-types.show')->where('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        Route::post('application-types', [App\Http\Controllers\Admin\ApplicationTypeController::class, 'store'])->name('application-types.store');
        Route::put('application-types/{uuid}', [App\Http\Controllers\Admin\ApplicationTypeController::class, 'update'])->name('application-types.update')->where('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        Route::delete('application-types/{uuid}', [App\Http\Controllers\Admin\ApplicationTypeController::class, 'destroy'])->name('application-types.destroy')->where('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        
        // Gestion des commandes avec données dynamiques
        Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders');
        Route::get('orders/{uuid}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('orders', [App\Http\Controllers\Admin\OrderController::class, 'store'])->name('orders.store');
        Route::put('orders/{uuid}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
        Route::delete('orders/{uuid}', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('orders/{uuid}/activate', [App\Http\Controllers\Admin\OrderController::class, 'activate'])->name('orders.activate');
        
        // Gestion du support avec données dynamiques
        Route::get('support', [App\Http\Controllers\Admin\SupportController::class, 'index'])->name('support');
        Route::get('support/{uuid}', [App\Http\Controllers\Admin\SupportController::class, 'show'])->name('support.show');
        Route::post('support', [App\Http\Controllers\Admin\SupportController::class, 'store'])->name('support.store');
        Route::put('support/{uuid}', [App\Http\Controllers\Admin\SupportController::class, 'update'])->name('support.update');
        Route::delete('support/{uuid}', [App\Http\Controllers\Admin\SupportController::class, 'destroy'])->name('support.destroy');
        Route::post('support/{uuid}/reply', [App\Http\Controllers\Admin\SupportController::class, 'reply'])->name('support.reply');
        Route::post('support/{uuid}/resolve', [App\Http\Controllers\Admin\SupportController::class, 'resolve'])->name('support.resolve');

        // Routes pour les catégories
        Route::get('categories/{uuid}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('categories.show');
        Route::post('categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{uuid}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{uuid}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
        
        // Gestion des contacts (page existante)
        Route::get('contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts');
        Route::get('contacts/{uuid}', [App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
        Route::put('contacts/{uuid}', [App\Http\Controllers\Admin\ContactController::class, 'update'])->name('contacts.update');
        Route::delete('contacts/{uuid}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::patch('contacts/{uuid}/replied', [App\Http\Controllers\Admin\ContactController::class, 'markAsReplied'])->name('contacts.replied');
        Route::patch('contacts/{uuid}/closed', [App\Http\Controllers\Admin\ContactController::class, 'markAsClosed'])->name('contacts.closed');
        
        // Gestion des catégories (remplace la route view par le contrôleur)
        Route::get('categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');
        
        // Gestion des utilisateurs (contrôleur existant)
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
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
