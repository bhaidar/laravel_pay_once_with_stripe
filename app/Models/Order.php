<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Cashier;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function total()
    {
        return Cashier::formatAmount($this->products->sum('price'), config('cashier.currency'));
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
