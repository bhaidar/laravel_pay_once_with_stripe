<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function __invoke()
    {
        $products = Product::get();

        return Inertia::render('Products/Index', ['products' => $products]);
    }
}
