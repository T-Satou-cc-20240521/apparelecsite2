<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Products\VariantController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CategoryController;
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
Route::middleware(['admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/top', [AdminController::class, 'top'])->name('top');
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/list', [ProductController::class, 'list'])->name('product.list');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
    Route::post('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::prefix('{product}/variant')->as('products.variant.')->group(function () {
        Route::post('/update', [VariantController::class, 'update'])->name('update');
        Route::post('/store', [VariantController::class, 'store'])->name('store');
        Route::delete('{variant}/delete', [VariantController::class, 'delete'])->name('delete');
    });
    Route::get('/tag/list', [TagController::class, 'list'])->name('tag.list');
    Route::get('/tag/create', [TagController::class, 'create'])->name('tag.create');
    Route::post('/tag', [TagController::class, 'store'])->name('tag.store');
    Route::get('/tag/{id}', [TagController::class, 'detail'])->name('tag.detail');
    Route::post('/tag/{id}/update', [TagController::class, 'update'])->name('tag.update');
    Route::delete('/tag/{id}', [TagController::class, 'delete'])->name('tag.delete');
    Route::get('/category/list', [CategoryController::class, 'list'])->name('category.list');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/category/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::get('/order/index', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/list', [OrderController::class, 'list'])->name('order.list');
    Route::get('/order/{id}', [OrderController::class, 'detail'])->name('order.detail');
    Route::post('/order/{id}/status-update', [OrderController::class, 'updateStatus'])->name('order.status.update');
    Route::get('/order/{id}/shipment/edit', [OrderController::class, 'editShipment'])->name('order.shipment.edit');
    Route::post('/order/{id}/shipment/update', [OrderController::class, 'updateShipment'])->name('order.shipment.update');
    Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('/report/index', [ReportController::class, 'index'])->name('report.index');
    Route::get('/user/index', [UserManagementController::class, 'index'])->name('user.index');
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
