<?php

namespace App\Http\Controllers\Api;

use App\Enums\TransactionStatus;
use App\Events\TransactionStatusUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $transaction = Transaction::where('code', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        switch ($transactionStatus) {
            case 'capture':
            if ($request->payment_type == 'credit_card') {
                if ($request->fraud_status == 'challenge') {
                    $transaction->update(['status' => TransactionStatus::PENDING->value]);
                } else {
                    $transaction->update(['status' => TransactionStatus::SUCCESS->value]);
                }
            }
            break;

            case 'settlement':
            $transaction->update(['status' => TransactionStatus::SUCCESS->value]);
            break;

            case 'pending':
            $transaction->update(['status' => TransactionStatus::PENDING->value]);
            break;

            case 'deny':
            $transaction->update(['status' => TransactionStatus::FAILED->value]);
            break;

            case 'expire':
            $transaction->update(['status' => TransactionStatus::FAILED->value]);
            break;

            case 'cancel':
            $transaction->update(['status' => TransactionStatus::FAILED->value]);
            break;

            default:
            $transaction->update(['status' => TransactionStatus::FAILED->value]);
            break;
        }

        TransactionStatusUpdated::dispatch($transaction);


        return response()->json(['message' => 'Transaction updated successfully']);
    }
}
