<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Cashier;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->withTimestamps();
    }

    public function scopeBySession()
    {
        return $this->where('session_id', session()->getId())->latest();
    }

    public function total()
    {
        return Cashier::formatAmount($this->products->sum('price'), config('cashier.currency'));
    }
}
