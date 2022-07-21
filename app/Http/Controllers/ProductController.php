<?php

namespace App\Http\Controllers;

use App\Http\Services\ShortUrlService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    public function __construct(ShortUrlService $shortUrlService)
    {
        $this->shortUrlService = $shortUrlService;
    }
    public function index()
    {
        $data = Product::all();
        // dd(json_decode(Redis::get('products')));
        return view('web.index', [
            'products' => $data
        ]);
    }
    public function checkProduct(Request $request)
    {
        // dd('ok');
        $id = $request->all()['id'];
        $product = Product::find($id);
        if ($product->quantity > 0) {
            return response(true);
        }else {
            return response(false);
        }
    }
    public function sharedUrl($id)
    {
        $url = $this->shortUrlService->makeShorturl("http://localhost:8000/products/$id");
        return response(['url' => $url]);
    }
}
