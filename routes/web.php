<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route de test pour le panier
Route::get('/test-cart', function () {
    return view('test-cart');
})->name('test.cart');

// Routes de récupération de mot de passe (publiques)
Route::get('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Route publique pour les détails des produits
Route::get('/product/{slug}', [App\Http\Controllers\Public\ProductController::class, 'show'])->name('product.details');

// Routes pour le panier
Route::post('/add-to-cart', [App\Http\Controllers\Public\CartController::class, 'addToCart'])->name('cart.add');
Route::post('/clear-cart', [App\Http\Controllers\Public\CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/get-cart', [App\Http\Controllers\Public\CartController::class, 'getCart'])->name('cart.get');
Route::get('/cart-count', [App\Http\Controllers\Public\CartController::class, 'getCartCount'])->name('cart.count');

// Route spécifique pour le dashboard (utilise UUID)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/product/{productUuid}', [DashboardController::class, 'showProduct'])->name('dashboard.product.details');
});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\ClientDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/profile/update', [App\Http\Controllers\ClientDashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::post('/dashboard/settings/update', [App\Http\Controllers\ClientDashboardController::class, 'updateSettings'])->name('dashboard.settings.update');
    Route::get('/dashboard/orders/{uuid}/invoice', [App\Http\Controllers\ClientDashboardController::class, 'downloadInvoice'])->name('dashboard.orders.invoice');
    Route::put('/dashboard/update-profile', [DashboardController::class, 'updateProfile'])->name('dashboard.updateProfile');
    Route::get('/dashboard/invoice/{subscription}/download', [DashboardController::class, 'downloadInvoice'])->name('dashboard.downloadInvoice');

    Route::get('/order/{subscriptionUuid}', [DashboardController::class, 'showOrderDetails'])->name('order.details');
    
    // Routes pour les notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [App\Http\Controllers\NotificationController::class, 'getRecentNotifications'])->name('notifications.recent');

    // Routes pour les paramètres
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/profile', [App\Http\Controllers\SettingsController::class, 'profile'])->name('settings.profile');
    Route::post('/settings/update', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/notifications', [App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('settings.notifications');
    Route::post('/settings/preferences', [App\Http\Controllers\SettingsController::class, 'updatePreferences'])->name('settings.preferences');
    Route::post('/dashboard/delete-account', [App\Http\Controllers\ClientDashboardController::class, 'deleteAccount'])->name('dashboard.delete-account');


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
        
        // Gestion du support admin
        Route::get('support', [App\Http\Controllers\Admin\SupportController::class, 'index'])->name('support.index');
        Route::get('support/{ticket}', [App\Http\Controllers\Admin\SupportController::class, 'show'])->name('support.show');
        Route::post('support/{ticket}/reply', [App\Http\Controllers\Admin\SupportController::class, 'reply'])->name('support.reply');
        Route::post('support/{ticket}/status', [App\Http\Controllers\Admin\SupportController::class, 'updateStatus'])->name('support.update-status');
        Route::post('support/{ticket}/assign', [App\Http\Controllers\Admin\SupportController::class, 'assign'])->name('support.assign');
        
 


        
        // Base de connaissances
        Route::get('knowledge-base/articles/{category}', [App\Http\Controllers\Admin\KnowledgeBaseController::class, 'articles'])->name('knowledge-base.articles');
        Route::get('knowledge-base/create-article', [App\Http\Controllers\Admin\KnowledgeBaseController::class, 'create'])->name('knowledge-base.create');
        
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
        Route::post('users/update-roles', [App\Http\Controllers\Admin\UserController::class, 'updateRoles'])->name('users.updateRoles');
        Route::get('users/list', [App\Http\Controllers\Admin\UserController::class, 'list'])->name('users.list');
        Route::delete('users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
        
        // Gestion des codes promo
        Route::get('promo-codes', [App\Http\Controllers\Admin\PromoCodeController::class, 'index'])->name('promo-codes.index');
        Route::get('promo-codes/create', [App\Http\Controllers\Admin\PromoCodeController::class, 'create'])->name('promo-codes.create');
        Route::post('promo-codes', [App\Http\Controllers\Admin\PromoCodeController::class, 'store'])->name('promo-codes.store');
        Route::get('promo-codes/{promoCode}', [App\Http\Controllers\Admin\PromoCodeController::class, 'show'])->name('promo-codes.show');
        Route::get('promo-codes/{promoCode}/edit', [App\Http\Controllers\Admin\PromoCodeController::class, 'edit'])->name('promo-codes.edit');
        Route::put('promo-codes/{promoCode}', [App\Http\Controllers\Admin\PromoCodeController::class, 'update'])->name('promo-codes.update');
        Route::delete('promo-codes/{promoCode}', [App\Http\Controllers\Admin\PromoCodeController::class, 'destroy'])->name('promo-codes.destroy');
        Route::post('promo-codes/{promoCode}/send', [App\Http\Controllers\Admin\PromoCodeController::class, 'sendToUsers'])->name('promo-codes.send');
        Route::post('promo-codes/{promoCode}/send-all', [App\Http\Controllers\Admin\PromoCodeController::class, 'sendToAllUsers'])->name('promo-codes.send-all');
        Route::get('promo-codes/users', [App\Http\Controllers\Admin\PromoCodeController::class, 'getUsersForPromo'])->name('promo-codes.users');
        Route::post('promo-codes/{promoCode}/toggle-status', [App\Http\Controllers\Admin\PromoCodeController::class, 'toggleStatus'])->name('promo-codes.toggle-status');
        Route::get('promo-codes/{promoCode}/duplicate', [App\Http\Controllers\Admin\PromoCodeController::class, 'duplicate'])->name('promo-codes.duplicate');
        

    });
    
    // Route pour télécharger les factures (admin)
    Route::get('/admin/orders/{subscriptionUuid}/download', [DashboardController::class, 'downloadInvoice'])->name('admin.orders.download');

});

Route::middleware(['auth'])->group(function () {
    
    // Support routes for authenticated users
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/test', function() { return view('support.test'); })->name('test');
        Route::get('/', [App\Http\Controllers\SupportController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\SupportController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\SupportController::class, 'store'])->name('store');
        Route::get('/{ticket}', [App\Http\Controllers\SupportController::class, 'show'])->name('show');
        Route::post('/{ticket}/reply', [App\Http\Controllers\SupportController::class, 'reply'])->name('reply');
        Route::post('/{ticket}/close', [App\Http\Controllers\SupportController::class, 'close'])->name('close');
    });
    
 
});

Route::get('/success', function () {
    return view('pages.success');
})->name('success');

require __DIR__.'/auth.php';
