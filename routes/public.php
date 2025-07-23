<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\FormsController;
use App\Http\Controllers\Public\ReviewController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\CheckoutController;

Route::view('/', 'pages.home')->name('home');
Route::get('/revendeur',function(){
    $product = Product::where('type', 'revendeur')->first();
    if (!$product) {
        abort(404, 'Produit revendeur introuvable');
    }
    return redirect()->route('product', $product->slug);
})->name('revendeur');
Route::get('/test-iptv', function(){
    $product = Product::where('type', 'testiptv')->first();
    if (!$product) {
        abort(404, 'Produit testiptv introuvable');
    }
    return redirect()->route('product', $product->slug);
})->name('testiptv');
Route::get('/application', function(){
    $product = Product::where('type', 'application')->first();
    if (!$product) {
        abort(404, 'Produit application introuvable');
    }
    return redirect()->route('product', $product->slug);
})->name('application');
Route::get('/abonnement', function(){
    $product = Product::where('type', 'abonnement')->first();
    if (!$product) {
        abort(404, 'Produit abonnement introuvable');
    }
    return redirect()->route('product', $product->slug);
})->name('abonnement');
Route::get('/renouvellement', function(){
    $product = Product::where('type', 'renouvellement')->first();
    if (!$product) {
        abort(404, 'Produit renouvellement introuvable');
    }
    return redirect()->route('product', $product->slug);
})->name('Renouvellement');

Route::view('/channels-vods', 'pages.channels-vods')->name('channels-vods');
Route::view('/mon-compte', 'pages.mon-compte')->name('Moncompte');
Route::view('/contactez-nous', 'pages.contactez-nous')->name('Contactez-nous');
Route::view('/tutoriel', 'pages.tutoriel')->name('Tutoriel');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product');
Route::view('/chaines-vods', 'pages.chainesvods')->name('chaines-vods');
Route::view('/assistance', 'pages.assistance')->name('assistance');
Route::view('/chainesvods', 'pages.chainesvods')->name('Abonnements');
Route::post('/product/{slug}', [FormsController::class, 'abonnement'])->name('form.abonnements');
Route::post('/product/{slug}', [FormsController::class, 'revendeur'])->name('form.revendeur');
Route::post('/product/{slug}', [FormsController::class, 'renouvellement'])->name('form.renouvellement');
Route::post('/forms', [FormsController::class, 'forms'])->name('forms');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store');

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::get('/boutique', [\App\Http\Controllers\Public\ProductController::class, 'boutique'])->name('boutique.index');


