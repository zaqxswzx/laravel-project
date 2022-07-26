<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateProduct;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productCount = Product::count(); // 總共有幾筆
        $dataPerPage = 5; // 每一頁的資料有幾筆
        $productPages = ceil($productCount / $dataPerPage); // 總頁數
        $currentPage = isset($request->all()['page']) ? $request->all()['page'] : 1; // 目前頁數
        $products = Product::orderBy('id', 'desc')
                                ->offset($dataPerPage * ($currentPage - 1))
                                ->limit($dataPerPage)
                                ->get();
        return view('admin.products.index', ['products' => $products,
                                            'productCount' => $productCount,
                                            'productPages' => $productPages
                                            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateProduct $validateProduct)
    {
        $data = $validateProduct->validated();
        Product::insert([
            'title' => $data['title'],
            'content' => $data['content'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back();
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
    public function update(ValidateProduct $validateProduct, $id)
    {
        $form = $validateProduct->validated();
        $item = Product::find($id);
        $item->update([
            'title' => $form['title'],
            'content' => $form['content'],
            'price' => $form['price'],
            'quantity' => $form['quantity'],
        ]);
        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dump($id);
        $form = Product::find($id);
        $form->delete();
        return redirect('/admin/products');
    }
}
