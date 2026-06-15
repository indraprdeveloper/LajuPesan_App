<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionPdfController;
use App\Http\Controllers\StoreQrCodeController;
use App\Models\User;

Route::get('/transaksi/cetak-pdf', [TransactionPdfController::class, 'export'])
    ->middleware(['auth', 'verified'])
    ->name('transaksi.cetak-pdf');

Route::get('/store/qr-code/download', [StoreQrCodeController::class, 'download'])
    ->middleware(['auth', 'verified'])
    ->name('store.qr-code.download');

Route::get('/sitemap.xml', function () {
    $users = User::whereNotNull('username')->get();
    $baseUrl = config('app.url');

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // Homepage
    $xml .= '<url>';
    $xml .= '<loc>' . $baseUrl . '</loc>';
    $xml .= '<changefreq>daily</changefreq>';
    $xml .= '<priority>1.0</priority>';
    $xml .= '</url>';

    // Store pages
    foreach ($users as $user) {
        $xml .= '<url>';
        $xml .= '<loc>' . $baseUrl . '/' . $user->username . '</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return Response::make($xml, 200, [
        'Content-Type' => 'application/xml',
    ]);
});

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
