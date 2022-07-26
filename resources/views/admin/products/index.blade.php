@extends('layouts.admin_app')
@section('content')
<div class="product-info">
    <div class="info">
        <table id="table">
            <thead>
                <td>ID</td>
                <td>標題</td>
                <td>內容</td>
                <td>價格</td>
                <td>數量</td>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td class="title" data-title="{{ $product->title }}">{{ $product->title }}</td>
                    <td class="content" data-content="{{ $product->content }}">{{ $product->content }}</td>
                    <td class="price" data-price="{{ $product->price }}">{{ $product->price }}</td>
                    <td class="quantity" data-quantity="{{ $product->quantity }}">{{ $product->quantity }}</td>
                    <td>
                        <input class="open-panel" type="button" value="修改" data-id="{{ $product->id }}">
                    </td>
                    <td>
                        <form class="delete-form" action="/admin/products/{{ $product->id }}" method="POST">
                            @method('DELETE')
                            <input class="delete-row" type="submit" value="刪除">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="page">
        @for ($i = 1; $i <= $productPages; $i++)
            <a href="/admin/products?page={{ $i }}">第{{ $i }} 頁</a> &nbsp;
        @endfor
    </div>    
</div>
<div class="modify">
    <div class="increase">
        <h2>新增商品</h2>
        <form action="/admin/products" method="POST">
            <label for="title">標題</label>
            <input type="text" name="title" id="post-title"><br>
            <label for="content">內容</label>
            <input type="text" name="content" id="post-content"><br>
            <label for="price">價格</label>
            <input type="text" name="price" id="post-price"><br>
            <label for="quantity">數量</label>
            <input type="text" name="quantity" id="post-quantity"><br>
            <input type="submit" value="傳送" class="submit"><br>
        </form>
    </div>
    <div class="panel">
        <h2>修改商品</h2>
        <form id="update-product" method="POST" enctype="application/x-www-form-urlencoded">
            @csrf
            @method('PUT')
            <label id="product-id-label" name="id"></label><br>
            <input type="hidden" id="product-id" name="id">
            <label for="title">標題</label>
            <input type="text" name="title" id="product-title"><br>
            <label for="content">內容</label>
            <input type="text" name="content" id="product-content"><br>
            <label for="price">價格</label>
            <input type="text" name="price" id="product-price"><br>
            <label for="quantity">數量</label>
            <input type="text" name="quantity" id="product-quantity"><br>
            <input type="submit" value="傳送" class="submit"><br>
        </form>
    </div>
</div>
<script>
    var tableLength = $('#table tbody tr').length
    $('.open-panel').click(function(){
        currentRow = $(this).closest("tr")
        $('.panel').css('display', 'block')
        var id = $(this).data('id')
        $('#update-product').attr('action', "/admin/products/" + id)
        $('#product-id').val(id)
        $('#product-id-label').text("ID: " + id)
        $('#product-title').val(currentRow.find("td:eq(1)").text())
        $('#product-content').val(currentRow.find("td:eq(2)").text())
        $('#product-price').val(currentRow.find("td:eq(3)").text())
        $('#product-quantity').val(currentRow.find("td:eq(4)").text())
    })
    $('.delete-row').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('確定要刪除嗎?')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
        }
    });
</script>
@endsection
