<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Product;
use App\Events\TransactionStatusUpdated;
use App\Jobs\AutoFailCashTransaction;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Cookie;
use App\Services\TransactionService;
use App\Enums\TransactionStatus;

class TransactionController extends Controller
{
    public function cart(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        return view('pages.cart', compact('store'));
    }

    public function customerInformation(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        return view('pages.customer-information', compact('store'));
    }

    public function checkout(Request $request, TransactionService $transactionService)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'table_number' => 'required|string|max:50',
            'payment_method' => 'required|in:cash,midtrans',
            'cart' => 'required|string',
        ]);

        $carts = json_decode($request->cart, true);
        
        if (empty($carts) || !is_array($carts)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Keranjang kosong atau format tidak valid.'], 400);
            }
            return back()->with('error', 'Keranjang kosong atau format tidak valid.');
        }

        foreach ($carts as $item) {
            $product = Product::find($item['id']);
            if (!$product || !$product->is_available) {
                $productName = $product ? $product->name : 'Menu';
                $msg = "Maaf, menu '{$productName}' saat ini sedang habis. Silakan hapus dari keranjang Anda.";
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['message' => $msg], 422);
                }
                return back()->with('error', $msg);
            }
        }

        $totalPrice = $transactionService->calculateCartTotal($carts);
        
        $transaction = $transactionService->createCheckoutTransaction(
            $store, 
            $request->only(['name', 'phone_number', 'table_number', 'payment_method']), 
            $carts, 
            $totalPrice
        );

        return $transactionService->processPayment($transaction, $store);
    }

    public function success(Request $request)
    {
        $transaction = Transaction::where('code', $request->order_id)->first();

        if (!$transaction) {
            abort(404);
        }

        $store = $transaction->user;

        return view('pages.success', compact('transaction', 'store'));
    }

    public function failed(Request $request)
    {
        $transaction = Transaction::where('code', $request->order_id)->first();

        if (!$transaction) {
            abort(404);
        }

        $store = $transaction->user;

        if ($transaction->status === TransactionStatus::PENDING->value) {
            $transaction->update(['status' => TransactionStatus::FAILED->value]);
            TransactionStatusUpdated::dispatch($transaction);
        }

        return view('pages.failed', compact('transaction', 'store'));
    }

    public function cancelTransaction(Request $request)
    {
        $transaction = Transaction::where('code', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $userTransactions = json_decode(request()->cookie('user_transactions', '[]'), true);
        if (!in_array($transaction->id, $userTransactions)) {
            return response()->json(['status' => 'unauthorized'], 403);
        }

        // Hanya batalkan jika masih pending
        if ($transaction->status === TransactionStatus::PENDING->value) {
            $transaction->transactionDetails()->delete();
            $transaction->delete();
        }

        return response()->json(['status' => 'cancelled']);
    }

    public function rating(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $transaction = Transaction::with('transactionDetails.product')
            ->where('code', $request->transaction_code)
            ->first();

        if (!$transaction) {
            abort(404);
        }

        $userTransactions = json_decode(request()->cookie('user_transactions', '[]'), true);
        if (!in_array($transaction->id, $userTransactions)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki akses ke pesanan ini.');
        }

        // Cek apakah sudah di-rating
        if ($transaction->is_rated) {
            return redirect()->route('index', $store->username)
                ->with('message', 'Pesanan ini sudah diberi rating.');
        }

        return view('pages.rating', compact('store', 'transaction'));
    }

    public function submitRating(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $transaction = Transaction::where('code', $request->transaction_code)->first();

        if (!$transaction || $transaction->is_rated) {
            abort(404);
        }

        $userTransactions = json_decode(request()->cookie('user_transactions', '[]'), true);
        if (!in_array($transaction->id, $userTransactions)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki akses ke pesanan ini.');
        }

        $ratings = $request->input('ratings', []);
        $reviews = $request->input('reviews', []);

        foreach ($ratings as $productId => $rating) {
            ProductReview::create([
                'transaction_id' => $transaction->id,
                'product_id' => $productId,
                'user_id' => $store->id,
                'rating' => $rating,
                'review' => $reviews[$productId] ?? null,
            ]);
        }

        $transaction->update(['is_rated' => true]);

        return redirect()->route('index', $store->username)
            ->with('rating_success', 'Terima kasih atas rating Anda!');
    }
}
