<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\UserFavoriteController;
use App\Http\Controllers\Admin\UserReviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\MyPageController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// 管理者ルート
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/top', [AdminController::class, 'top'])->name('top');
    Route::get('/product/list', [ProductController::class, 'list'])->name('product.list');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
    Route::post('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'detail'])->name('orders.detail');
    Route::post('/orders/{id}/status-update', [AdminOrderController::class, 'updateStatus'])->name('orders.status.update');
    Route::get('/orders/{id}/shipment/edit', [AdminOrderController::class, 'editShipment'])->name('orders.shipment.edit');
    Route::post('/orders/{id}/shipment/update', [AdminOrderController::class, 'updateShipment'])->name('orders.shipment.update');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});

// 認証関連ルート
Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register/confirm', [RegisterController::class, 'confirm'])->name('register.confirm');
    Route::post('/register/complete', [RegisterController::class, 'complete'])->name('register.complete');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/{provider}/redirect', [SocialLoginController::class, 'redirectToProvider'])->name('social.redirect');
    Route::get('/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback'])->name('social.callback');
});

// 一般ユーザー（非ログイン時アクセス可）
Route::group(['prefix' => '/user', 'as' => 'user.'], function () {
    Route::get('/top', [UserController::class, 'top'])->name('top');
    Route::get('/product/list', [UserProductController::class, 'list'])->name('product.list');
    Route::get('/product/{id}', [UserProductController::class, 'detail'])->name('product.detail');
    Route::get('/cart/list', [CartController::class, 'list'])->name('cart.list');
    Route::get('/cart/{id}', [CartController::class, 'detail'])->name('cart.detail');
});

// 一般ユーザー（ログイン時のみ可）
Route::group(['prefix' => '/user', 'as' => 'user.', 'middleware' => 'auth'], function () {
    Route::post('/favorite/{id}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
    Route::get('/favorites', [FavoriteController::class, 'list'])->name('favorites.list');
    Route::get('/mypage/list', [MyPageController::class, 'list'])->name('mypage.list');
    Route::get('/mypage/edit', [MyPageController::class, 'edit'])->name('mypage.edit');
    Route::post('/mypage/confirm', [MyPageController::class, 'confirm'])->name('mypage.confirm');
    Route::post('/mypage/update', [MyPageController::class, 'update'])->name('mypage.update');
    Route::get('/', [UserOrderController::class, 'list'])->name('user_order.list');
    Route::get('/{id}', [UserOrderController::class, 'detail'])->name('user_order.detail');
    Route::post('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');
    Route::post('/cart/complete', [CartController::class, 'complete'])->name('cart.complete');
    Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirectToProvider'])->name('auth.redirect');
    Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback'])->name('auth.callback');
});

Route::get('/', function () {
    return view('user.top');
});
