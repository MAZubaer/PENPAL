
<?php
// Product reviews
Route::post('products/{product}/review', [App\Http\Controllers\ReviewController::class, 'store'])->middleware('auth')->name('products.review');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookmarkController;

// Coupon management (admin only, controlled by Blade UI)
Route::middleware('auth')->group(function () {
    Route::get('coupons', [App\Http\Controllers\CouponController::class, 'index'])->name('coupons.index');
    Route::get('coupons/create', [App\Http\Controllers\CouponController::class, 'create'])->name('coupons.create');
    Route::post('coupons', [App\Http\Controllers\CouponController::class, 'store'])->name('coupons.store');
    Route::delete('coupons/{id}', [App\Http\Controllers\CouponController::class, 'destroy'])->name('coupons.destroy');
    Route::get('coupons/history', [App\Http\Controllers\CouponController::class, 'history'])->name('coupons.history');
});

// Apply coupon at checkout
Route::post('checkout/apply-coupon', [App\Http\Controllers\CheckoutController::class, 'applyCoupon'])->middleware('auth')->name('checkout.applyCoupon');

Route::get('bookmarks', [BookmarkController::class, 'index'])->middleware('auth')->name('bookmarks.index');
Route::post('bookmarks/{product}', [BookmarkController::class, 'store'])->middleware('auth')->name('bookmarks.store');
Route::delete('bookmarks/{id}', [BookmarkController::class, 'destroy'])->middleware('auth')->name('bookmarks.destroy');
Route::post('bookmarks/add-to-cart/{id}', [BookmarkController::class, 'addToCart'])->middleware('auth')->name('bookmarks.addToCart');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('products', App\Http\Controllers\ProductController::class);
Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::get('categories/{category}/products', [App\Http\Controllers\ProductController::class, 'byCategory'])->name('categories.products');
Route::get('cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('cart/update/{product}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('cart/update-all', [App\Http\Controllers\CartController::class, 'updateAll'])->name('cart.update.all');
Route::post('cart/remove/{product}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('order/input', [OrderController::class, 'input'])->name('order.input');
Route::post('order', [OrderController::class, 'store'])->name('order.store');
Route::get('orders/confirmation/{id}', [OrderController::class, 'confirmation'])->name('orders.confirmation');
Route::get('admin/orders', [OrderController::class, 'adminOrders'])->middleware('auth')->name('orders.admin');
Route::get('orders/user', [OrderController::class, 'userOrders'])->middleware('auth')->name('orders.user');
Route::post('orders/cancel/{id}', [OrderController::class, 'cancel'])->middleware('auth')->name('orders.cancel');
Route::post('admin/orders/process/{id}', [OrderController::class, 'process'])->middleware('auth')->name('orders.process');
