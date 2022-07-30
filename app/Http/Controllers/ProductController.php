<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function show(Request $request, Product $product)
    {
        return Inertia::render('Products/Show', ['product' => $product]);
    }
}
