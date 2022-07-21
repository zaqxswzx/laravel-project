<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class CartService
{
    // 目的是讓數字有明確的意義
    const VIP_LEVEL = 2;
    const VIP_RATE = 0.8;
    const NORMAL_RATE = 1;
    
    public function checkouted($cart)
    {
        DB::beginTransaction();
        try {
            $lackCartItem = $this->checkLackCartItem($cart->cartItems);
            if ($lackCartItem){
                return $lackCartItem->product->title.'數量不足';
            }
            $rate = $this->cartRate($cart);
            $order = $this->createOrder($cart, $rate);
            $cart->update(['checkouted' => true]);
            $order->orderItems;
            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            DB::rollback();
            return 'something error';
        }
    }
    // 將個別的功能拆出來
    // checkLackCartItem 是否數量足夠
    public function checkLackCartItem($cartItems)
    {
        return $cartItems->filter(function($cartItem){
            return $cartItem->product->quantity < $cartItem->quantity;
        })->first();
    }
    // cartRate 折扣
    public function cartRate($cart)
    {
        return $cart->user->level == self::VIP_LEVEL ? self::VIP_RATE : self::NORMAL_RATE;
    }
    // createOrder 新增order
    public function createOrder($cart, $rate)
    {
        $order = $cart->order()->create([
            'user_id' => $cart->user_id
        ]);
        foreach($cart->cartItems as $cartItem){
            $order->orderItems()->create([
                'cartItem_id' => $cartItem->id,
                'price' => $cartItem->product->price * $rate
            ]);
            $cartItem->product()->update([
                'quantity' => $cartItem->product->quantity - $cartItem->quantity
            ]);
        }
        return $order;
    }
}