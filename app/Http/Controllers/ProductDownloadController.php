<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductDownloadController extends Controller
{
    public function show(Product $product, Request $request)
    {
        throw_unless(
            $request->user()->orders->pluck('products')->flatten()->contains('id', $product->id),
            ModelNotFoundException::class,
        );

        return Storage::disk('local')->download($product->file_path);
    }
}
