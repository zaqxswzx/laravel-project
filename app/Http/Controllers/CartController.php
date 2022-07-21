<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;
    protected $cartRepository;
    public function __construct(CartService $cartService, CartRepository $cartRepository)
    {
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $cart = $this->cartRepository->scopeBelongsUser($user)
                    ->firstOrCreate(['user_id'=>$user->id]);
        return response($cart);
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
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
    public function checkout()
    {
        $user = auth()->user();
        $cart = $user->carts()->where('checkouted', false)->with('cartItems')->first();
        if ($cart) {
            $result = $this->cartService->checkouted($cart);
            return response($result);
        }else{
            return response('沒有購物車', 400);
        }
    }
}
