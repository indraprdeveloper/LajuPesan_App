<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionPdfController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = 'success'; // Hanya transaksi berhasil
        $userId = $request->input('user_id');

        // Build query
        $query = Transaction::with('user')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('status', $status);

        // Role-based filtering
        if ($user->role === 'store') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'admin' && $userId) {
            $query->where('user_id', $userId);
        }

        $transactions = $query->orderBy('created_at', 'asc')->get();

        // Calculate totals
        $grandTotal = $transactions->sum('total_price');

        $cashTransactions = $transactions->where('payment_method', 'cash');
        $nonCashTransactions = $transactions->where('payment_method', 'midtrans');

        $totalCash = [
            'count' => $cashTransactions->count(),
            'amount' => $cashTransactions->sum('total_price'),
        ];

        $totalNonCash = [
            'count' => $nonCashTransactions->count(),
            'amount' => $nonCashTransactions->sum('total_price'),
        ];

        // Determine store name
        $storeName = null;
        if ($user->role === 'store') {
            $storeName = $user->name;
        } elseif ($user->role === 'admin' && $userId) {
            $storeName = \App\Models\User::find($userId)?->name;
        }

        $pdf = Pdf::loadView('pdf.transactions-report', [
            'transactions' => $transactions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'grandTotal' => $grandTotal,
            'totalCash' => $totalCash,
            'totalNonCash' => $totalNonCash,
            'storeName' => $storeName,
            'role' => $user->role,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'Laporan_Transaksi_' . $startDate . '_sd_' . $endDate . '.pdf';

        return $pdf->download($filename);
    }
}
