<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderDelivery;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function delivery($id)
    {
        $order = Order::find($id);
        if ($order->is_shipped){
            return response(['result' => false]);
        }else{
            $order->update(['is_shipped' => true]);
            $order->user->notify(new OrderDelivery);
            return response(['result' => true]);
        }
    }
}
