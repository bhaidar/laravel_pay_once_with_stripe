<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function __invoke()
    {
        $products = ProductResource::collection(Product::get());

        return Inertia::render('Products/Index', ['products' => $products]);
    }
}
