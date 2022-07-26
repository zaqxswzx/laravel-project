@extends('layouts.app')
@section('content')
<script src="{{ mix('js/app.js') }}"></script>
<div class="login-form">
    <form action="/login" method="POST">
        <label for="name">名字：</label>
        <input type="text" name="name"><br>
        <label for="email">email: </label>
        <input type="text" name="email"><br>
        <label for="password">密碼：</label>
        <input type="text" name="password"><br>
        <input type="submit" value="登入">
    </form>
</div>
@endsection
