<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{

    public function find(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        return view('pages.find', compact('store'));
    }

    public function findResult(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $products = Product::where('user_id', $store->id);
        
        if(isset($request->category)) {
            $category = ProductCategory::where('user_id', $store->id)->where('user_id', $store->id)
                ->where('slug', $request->category)->first(); 
            
            $products = $products->where('product_category_id', $category->id);
        }

        if(isset($request->search)) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $products->get();

        return view('pages.result', compact('store', 'products'));
    }
    
    public function show(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $product = Product::where('user_id', $store->id)->where('id', $request->id)->first();

        if (!$product) {
            abort(404);
        }

        // Ambil review dari database
        $reviews = \App\Models\ProductReview::where('product_id', $product->id)
            ->with('transaction')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.product', compact('store', 'product', 'reviews'));
    }
}
