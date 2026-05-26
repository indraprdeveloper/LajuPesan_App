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

    public function checkout(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $carts = json_decode($request->cart, true);

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $product = Product::where('id', $cart['id'])->first();
            $totalPrice += $product->price * $cart['qty'];
        } 

        $transaction = $store->transactions()->create([
            'code' => 'TRX-' . mt_rand(10000, 99999),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'table_number' => $request->table_number,
            'payment_method' => $request->payment_method,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

                foreach ($carts as $cart) {
          $product = Product::where('id', $cart['id'])->first();
            $transaction->transactionDetails()->create([
                'product_id' => $product->id,
                'quantity' => $cart['qty'],
                'note' => $cart['notes'],
            ]);
        }

        TransactionStatusUpdated::dispatch($transaction);

        if ($request->payment_method == 'cash') {
            // Jadwalkan auto-gagal dalam 5 menit jika kasir tidak mengubah status
            AutoFailCashTransaction::dispatch($transaction->id)->delay(now()->addMinutes(5));

            return redirect()->route('success', ['username' => $store->username, 'order_id' => $transaction->code]);
        } else {
            //Atur Kunci Server Merchant Anda
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            //Set to Development/Sandbox Environment (default)
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->code,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'phone' => $request->phone_number,
                ],
                'expiry' => [
                    'start_time' => date("Y-m-d H:i:s O"),
                    'unit' => 'minute',
                    'duration' => 5,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Jadwalkan auto-gagal dalam 5 menit jika pembayaran belum diselesaikan
            AutoFailCashTransaction::dispatch($transaction->id)->delay(now()->addMinutes(5));
            
            return response()->json([
                'snap_token' => $snapToken,
                'success_url' => route('success', ['username' => $store->username, 'order_id' => $transaction->code]),
                'failed_url' => route('failed', ['username' => $store->username, 'order_id' => $transaction->code]),
                'customer_info_url' => route('customer-information', ['username' => $store->username]),
                'cancel_url' => route('transaction.cancel', ['username' => $store->username, 'order_id' => $transaction->code]),
            ]);
        }
    }

    public function success(Request $request)
    {
        $transaction = Transaction::where('code', $request->order_id)->first();

        if (!$transaction) {
            abort(404);
        }

        $store = $transaction->user;

        if ($transaction->payment_method !== 'cash' && $transaction->status !== 'success') {
            $transaction->update(['status' => 'success']);
            TransactionStatusUpdated::dispatch($transaction);
        }

         // Ambil daftar ID transaksi dari HP ini (jika ada)
    $userTransactions = json_decode(request()->cookie('user_transactions', '[]'), true);

    // Jika ID transaksi saat ini belum tersimpan di HP ini, maka simpan
    if (!in_array($transaction->id, $userTransactions)) {
        $userTransactions[] = $transaction->id;
        // Simpan ke cookie selama 30 hari (43200 menit)
        Cookie::queue('user_transactions', json_encode($userTransactions), 43200);
    }

        return view('pages.success', compact('transaction', 'store'));
    }

    public function failed(Request $request)
    {
        $transaction = Transaction::where('code', $request->order_id)->first();

        if (!$transaction) {
            abort(404);
        }

        $store = $transaction->user;

        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'failed']);
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

        // Hanya batalkan jika masih pending
        if ($transaction->status === 'pending') {
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
