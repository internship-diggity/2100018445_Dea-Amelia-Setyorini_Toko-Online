<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'detail'])->name('categories-detail');

Route::get('/details/{id}', [App\Http\Controllers\DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}', [App\Http\Controllers\DetailController::class, 'add'])->name('detail-add');

Route::post('/checkout/callback', [App\Http\Controllers\CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::get('/success', [App\Http\Controllers\CartController::class, 'success'])->name('success');

Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'success'])->name('register-success');
Route::get('register/check', [App\Http\Controllers\Auth\RegisterController::class, 'check'])->name('api-register-check');

Route::get('provinces', [App\Http\Controllers\API\LocationController::class, 'provinces'])->name('api-provinces');
Route::get('regencies/{provinces_id}', [App\Http\Controllers\API\LocationController::class, 'regencies'])->name('api-regencies');

Route::group(['middleware' => ['auth']], function(){
    
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])->name('cart-delete');

    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'index'])->name('dashboard-product');
    Route::get('/dashboard/products/create', [App\Http\Controllers\DashboardProductController::class, 'create'])->name('dashboard-product-create');
    Route::post('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'store'])->name('dashboard-product-store');
    Route::get('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'details'])->name('dashboard-product-details');
    Route::post('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'update'])->name('dashboard-product-update');

    Route::post('/dashboard/products/gallery/upload', [App\Http\Controllers\DashboardProductController::class, 'uploadGallery'])->name('dashboard-product-gallery-upload');
    Route::get('/dashboard/products/gallery/delete/{id}', [App\Http\Controllers\DashboardProductController::class, 'deleteGallery'])->name('dashboard-product-gallery-delete');

    Route::get('/dashboard/transactions', [App\Http\Controllers\DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
    Route::get('/dashboard/transactions/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'details'])->name('dashboard-transaction-details');
    Route::post('/dashboard/transactions/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');


    Route::get('/dashboard/settings', [App\Http\Controllers\DashboardSettingController::class, 'store'])->name('dashboard-settings-store');
    Route::get('/dashboard/account', [App\Http\Controllers\DashboardSettingController::class, 'account'])->name('dashboard-settings-account');
    Route::post('/dashboard/account/{redirect}', [App\Http\Controllers\DashboardSettingController::class, 'update'])->name('dashboard-settings-redirect');

});



Route::prefix(prefix: 'admin')
->namespace('App\Http\Controllers\Admin')
->middleware(['auth','admin'])
->group(function() {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin-dashboard');
    Route::resource('category', App\Http\Controllers\Admin\CategoryController::class); // Menentukan namespace lengkap
        Route::resource('user', App\Http\Controllers\Admin\UserController::class); // Menentukan namespace lengkap
        Route::resource('product', App\Http\Controllers\Admin\ProductController::class); // Menentukan namespace lengkap
        Route::resource('product-gallery', App\Http\Controllers\Admin\ProductGalleryController::class); // Menentukan namespace lengkap
        Route::resource('transaction', App\Http\Controllers\Admin\TransactionController::class);
});

Auth::routes();


