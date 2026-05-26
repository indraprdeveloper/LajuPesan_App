<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

Route::get('/{username}', [FrontendController::class, 'index'])
    ->name('index')
    ->where('username', '^(?!admin)[^/]+$');

Route::get('/{username}/profile', [FrontendController::class, 'profile'])->name('profile');



Route::get('/{username}/find-product', [ProductController::class, 'find'])->name('product.find');
Route::get('/{username}/find-product/result', [ProductController::class, 'findResult'])->name('product.find-result');
Route::get('/{username}/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/{username}/cart', [TransactionController::class, 'cart'])->name('cart');
Route::get('/{username}/customer-information', [TransactionController::class, 'customerInformation'])->name('customer-information');
Route::post('/{username}/checkout', [TransactionController::class, 'checkout'])->name('payment');
Route::get('/{username}/success', [TransactionController::class, 'success'])->name('success');
Route::get('/{username}/failed', [TransactionController::class, 'failed'])->name('failed');
Route::post('/{username}/cancel-transaction', [TransactionController::class, 'cancelTransaction'])->name('transaction.cancel');
Route::get('/{username}/rating/{transaction_code}', [TransactionController::class, 'rating'])->name('rating');
Route::post('/{username}/rating/{transaction_code}', [TransactionController::class, 'submitRating'])->name('rating.submit');
