<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartProductController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::query()->findOrFail($request->product_id);

        $cart = Cart::query()->firstOrCreate([
            'user_id' => auth()->id(), // null if not logged-in
            'session_id' => session()->getId(),
        ]);

        $cart->products()->syncWithoutDetaching($product);

        return redirect()->back();
    }

    public function destroy(Product $product)
    {
        $cart = Cart::bySession()->first()->products()->detach($product);

        return redirect()->back();
    }
}
