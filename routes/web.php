<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HandInController;
use App\Http\Controllers\LoanersController;
use App\Http\Controllers\LoanProductsController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UploadController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'processLogin'])->name('login_proccess');
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware('admin')->group(function () {
    Route::get('/adminHome', [AdminController::class, 'showHomePage'])->name('admin_home');
    Route::get('/loaners/overview', [AdminController::class, 'index'])->name('loaners_overview');
    Route::get('/loaners/details/{id}', [AdminController::class, 'show'])->name('loaners_details');
    Route::get('/loaners/create', [AdminController::class, 'createLoaner'])->name('loaners_create');
    Route::post('/loaners/create', [AdminController::class, 'storeLoaner'])->name('loaners_create');

    Route::get('/loaners/handin/{loaner}', [HandInController::class, 'indexAdmin'])->name('admin_handin');
    Route::post('loaners/handin/{loaner}', [HandInController::class, 'storeAdmin'])->name('admin_handin');

    Route::get('/loaners/{id}', [LoanProductsController::class, 'indexAdmin'])->name('loaners_loaning');
    Route::post('/loaners/{id}/loaning', [LoanProductsController::class, 'addProductToCartAdmin'])->name('loaners_product_add_to_cart');
    Route::post('/loaning/{id}', [LoanProductsController::class, 'storeAdmin'])->name('loaners_loaning_store');
    Route::post('/loaning/delete/{userId}', [LoanProductsController::class, 'deleteCartRowAdmin'])->name('loaners_product_delete');

    Route::get('/products/overview', [ProductController::class, 'index'])->name('product_index');
    Route::get('/products/details/{product}', [ProductController::class, 'show'])->name('product_details');
    Route::get('/products/preview/{product}', [ProductController::class, 'preview'])->name('product_preview');

    Route::get('/products/createProduct', [ProductController::class, 'create'])->name('product_create');
    Route::post('/products/createProduct', [ProductController::class, 'store'])->name('product_create');

    Route::get('/products/editProduct/{product}', [ProductController::class, 'edit'])->name('product_edit');
    Route::patch('/updateProduct/{product}', [ProductController::class, 'update'])->name('product_update');

    // route to update the due date of a loan
    Route::post('/updateDueDate/{loan}', [LoansController::class, 'updateLoan'])->name('loan.update');

    Route::get('/categories/overview', [CategoryController::class, 'index'])->name('category_overview');
    Route::get('categories/createCategory', [CategoryController::class, 'create'])->name('category_create');
    Route::post('categories/createCategory', [CategoryController::class, 'store'])->name('category_create');

    Route::get('/categories/details/{category}', [CategoryController::class, 'show'])->name('category_details');

    Route::get('categories/editCategory/{category}', [CategoryController::class, 'edit'])->name('category_edit');
    Route::patch('/updateCategory/{category}', [CategoryController::class, 'update'])->name('category_update');

    Route::post('/categories/details/{category}', [CategoryController::class, 'addProduct'])->name('category_product_add');
    Route::delete('/categories/details/{category}', [CategoryController::class, 'deleteProduct'])->name('category_product_delete');

    Route::get('/duedates/overview', [AdminController::class, 'showDueDates'])->name('due_dates_overview');
    Route::post('/duedates/overview', [AdminController::class, 'createDueDate'])->name('due_dates_create');
    Route::delete('/duedates/overview/{id}', [AdminController::class, 'deleteDueDate'])->name('due_dates_delete');

    Route::post('/returns/accept', [AdminController::class, 'acceptReturns'])->name('returns.accept-all');
    Route::post('/returns/reject', [AdminController::class, 'rejectReturns'])->name('returns.reject-all');
    Route::post('/returns/{returnId}/accept', [AdminController::class, 'acceptReturn'])->name('returns.acceptReturn');
    Route::post('/returns/{returnId}/reject', [AdminController::class, 'rejectReturn'])->name('returns.rejectReturn');
});

Route::middleware('loaner')->group(function () {

    Route::get('/dashboard', [LoanersController::class, 'dashboard'])->name('loaners_home');
    Route::get('/returns', [LoanersController::class, 'returns'])->name('loaner_returns');
    Route::get('/loaning', [LoanProductsController::class, 'index'])->name('loaning_index');
    Route::post('/loaning', [LoanProductsController::class, 'store'])->name('loaning_store');
    Route::get('/loaning/check-out', [LoanProductsController::class, 'getCheckOutPage'])->name('loaning_checkout');
    Route::post('/loaning/check-out', [LoanProductsController::class, 'updateCartArray'])->name('product_add');
    Route::post('/loaning/check-out/confirm', [LoanProductsController::class, 'deleteCartRow'])->name('product_delete');
    Route::post('/products/overview/loaners', [LoanProductsController::class, 'addProductToCart'])->name('product_add_to_cart');

    Route::get('/handin', [HandInController::class, 'index'])->name('hand_in');
    Route::post('/handin', [HandInController::class, 'store'])->name('hand_in');
    Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
    Route::post('/settings', [AccountController::class, 'changeSettings'])->name('settings');

    Route::get('/product/{product}', [ProductController::class, 'show_loaner'])->name('product_loaner_details');

    Route::get('autocomplete/{query}', [SearchController::class, 'autocomplete'])->name('autocomplete');
});


Route::get('/account', [AccountController::class, 'show'])->name('account');
