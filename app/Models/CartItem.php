<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [''];
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
