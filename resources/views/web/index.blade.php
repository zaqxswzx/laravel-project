@extends('layouts.app')
@section('content')
<div class="homepage">
    <table id="table">
        <thead>
            <td>ID</td>
            <td>標題</td>
            <td>內容</td>
            <td>價格</td>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td class="title" data-title="{{ $product->title }}">{{ $product->title }}</td>
                <td class="content" data-content="{{ $product->content }}">{{ $product->content }}</td>
                <td class="price" data-price="{{ $product->price }}">{{ $product->price }}</td>
                <td style="display: none" class="quantity" data-quantity="{{ $product->quantity }}">{{ $product->quantity }}</td>
                <td>
                    <input type="button" class="check_product" value="確認商品數量" data-id="{{ $product->id }}">
                </td>
                <td>
                    <input type="button" class="check_shared_url" value="分享商品" data-id="{{ $product->id }}">
                </td>
                {{-- <td>
                    <input class="open-panel" type="button" value="加入購物車" data-id="{{ $product->id }}">
                </td> --}}
                <td>
                    <input class="plus-quantity" type="button" value="+">
                    <input class="add-quantity" type="text" name="quantity" value="0">
                    <input class="minus-quantity" type="button" value="-">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $('.plus-quantity').click(function(){
        var quantity = $(this).closest("td").find('.add-quantity')
        var productQuantity = parseInt($(this).closest("tr").find('.quantity').text())
        quantity.val(parseInt(quantity.val())+1)
        console.log(productQuantity)
        if(parseInt(quantity.val()) > productQuantity) {
            quantity.val(productQuantity)
        }
        console.log(quantity.val())
    })
    $('.minus-quantity').click(function(){
        var quantity = $(this).closest("td").find('.add-quantity')
        quantity.val(parseInt(quantity.val())-1)
        if(parseInt(quantity.val()) < 0) {
            quantity.val(0)
        }
        console.log(quantity.val())
    })
    $('.add-quantity').keyup(function(){
        var productQuantity = parseInt($(this).closest("tr").find('.quantity').text())
        if (parseInt($(this).val()) > productQuantity) {
            $(this).val(productQuantity)
            $(this).text(productQuantity)
        }
        console.log($(this).val())
        console.log(productQuantity)
    })
    $('.check_product').click(function(){
        console.log('ok')
        $.ajax({
            method: 'POST',
            url: '/products/check-product',
            data: {id: $(this).data('id')}
        })
        .done(function(response){
            if(response){
                alert('商品數量充足')
            }else{
                alert('商品數量不足')
            }
        })
    })
    $('.check_shared_url').click(function(){
        var id = $(this).data('id')
        $.ajax({
            method: 'GET',
            url: `/products/${id}/shared-url`
        })
        .done(function(msg){
            alert('請分享此縮網址' + msg.url)
        })
    })
</script>
@endsection
