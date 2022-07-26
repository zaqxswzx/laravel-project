<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CartItem::select('*')->join('products', function($join){
            $join->on('products.id', '=', 'cart_items.product_id')
                ->where('products.quantity', '>', '10');
        })->get();
        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCartItem $addCartItem)
    {
        $user = auth()->user();
        $cart = $user->carts()->where('checkouted', false)->with('cartItems')->first();
        $item = $addCartItem->validated();
        $product = Product::find($item['product_id']);
        if ($product->quantity < $item['quantity']){
            return response($product->title.'數量不足',400);
        }
        $result = $cart->cartItems()->create([
            'quantity' => $item['quantity'],
            'product_id' => $product->id,
        ]);
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = $request->all();
        CartItem::find($id)->update([
            'quantity' => $item['quantity']
        ]);
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CartItem::find($id)->delete();
        return response()->json(true);
    }
}
