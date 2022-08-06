<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
                    ->orders()
                    ->with('products')
                    ->get()
                    ->map(function ($order) {
                        $order['total'] = $order->total();

                        return $order;
                    });

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }
}
