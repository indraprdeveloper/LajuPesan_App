<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;


class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $populars = Product::where('user_id', $store->id)->where('is_popular', true)->get();
        $products = Product::where('user_id', $store->id)->where('is_popular', false)->get();

        // Ambil daftar ID pesanan khusus dari HP/Browser ini saja
        $userTransactions = json_decode($request->cookie('user_transactions', '[]'), true);

        // Ambil transaksi yang belum di-rating (status success, belum rated)
        $unratedTransactions = \App\Models\Transaction::where('user_id', $store->id)
            ->where('status', 'success')
            ->where('is_rated', false)
            ->whereIn('id', $userTransactions)
            ->latest()
            ->get();

        return view('pages.index', compact('store', 'populars', 'products', 'unratedTransactions', 'userTransactions'));
    }

    public function profile(Request $request)
    {
        $store = User::with('storeSocialMedia')
            ->where('username', $request->username)
            ->first();

        if (!$store) {
            abort(404);
        }

        return view('pages.profile', compact('store'));
    }
}
