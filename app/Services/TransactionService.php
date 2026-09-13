<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Events\TransactionStatusUpdated;
use App\Jobs\AutoFailCashTransaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Enums\TransactionStatus;

class TransactionService
{
    /**
     * Menghitung total harga dari list produk keranjang.
     */
    public function calculateCartTotal(array $carts): float
    {
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $product = Product::where('id', $cart['id'])->first();
            if ($product) {
                $totalPrice += $product->price * $cart['qty'];
            }
        }
        return $totalPrice;
    }

    /**
     * Memproses checkout pesanan dan menyimpannya ke database.
     */
    public function createCheckoutTransaction(User $store, array $data, array $carts, float $totalPrice): Transaction
    {
        $transaction = $store->transactions()->create([
            'code' => 'TRX-' . strtoupper(Str::random(8)),
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'table_number' => $data['table_number'],
            'payment_method' => $data['payment_method'],
            'total_price' => $totalPrice,
            'status' => TransactionStatus::PENDING->value,
        ]);

        foreach ($carts as $cart) {
            $product = Product::where('id', $cart['id'])->first();
            if ($product) {
                $transaction->transactionDetails()->create([
                    'product_id' => $product->id,
                    'quantity' => $cart['qty'],
                    'note' => $cart['notes'] ?? null,
                ]);
            }
        }

        TransactionStatusUpdated::dispatch($transaction);
        $this->saveTransactionToCookie($transaction->id);

        return $transaction;
    }

    /**
     * Memproses logika spesifik berdasarkan metode pembayaran (Midtrans/Cash).
     */
    public function processPayment(Transaction $transaction, User $store)
    {
        if ($transaction->payment_method === 'cash') {
            AutoFailCashTransaction::dispatch($transaction->id)->delay(now()->addMinutes(5));
            return redirect()->route('success', ['username' => $store->username, 'order_id' => $transaction->code]);
        } 
        
        // Midtrans Logic
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'phone' => $transaction->phone_number,
            ],
            'expiry' => [
                'start_time' => date("Y-m-d H:i:s O"),
                'unit' => 'minute',
                'duration' => 5,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        AutoFailCashTransaction::dispatch($transaction->id)->delay(now()->addMinutes(5));
        
        return response()->json([
            'snap_token' => $snapToken,
            'success_url' => route('success', ['username' => $store->username, 'order_id' => $transaction->code]),
            'failed_url' => route('failed', ['username' => $store->username, 'order_id' => $transaction->code]),
            'customer_info_url' => route('customer-information', ['username' => $store->username]),
            'cancel_url' => route('transaction.cancel', ['username' => $store->username, 'order_id' => $transaction->code]),
        ]);
    }

    /**
     * Menghitung total transaksi khusus untuk tampilan Filament Admin
     */
    public function calculateResourceTotal($selectedProducts): float
    {
        $prices = Product::whereIn('id', $selectedProducts->pluck('product_id'))->pluck('price', 'id');
        
        return $selectedProducts->reduce(function ($total, $product) use ($prices) {
            return $total + (
                ($prices[$product['product_id']] ?? 0) * $product['quantity']
            );
        }, 0);
    }

    /**
     * Helper untuk menyimpan ID transaksi di Cookie User
     */
    private function saveTransactionToCookie($transactionId)
    {
        $userTransactions = json_decode(request()->cookie('user_transactions', '[]'), true);
        if (!in_array($transactionId, $userTransactions)) {
            $userTransactions[] = $transactionId;
            Cookie::queue('user_transactions', json_encode($userTransactions), 43200);
        }
    }
}
