<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [''];
    private $rate = 1;
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    public function order()
    {
        return $this->hasOne(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
