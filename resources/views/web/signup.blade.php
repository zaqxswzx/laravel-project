@extends('layouts.app')
@section('content')
<div class="signup-form">
    <form action="/signup" method="POST">
        <label for="name">名字：</label>
        <input type="text" name="name"><br>
        <label for="email">email: </label>
        <input type="text" name="email"><br>
        <label for="password">密碼：</label>
        <input type="text" name="password"><br>
        <label for="password_confirmation">密碼確認：</label>
        <input type="text" name="password_confirmation"><br>
        <input type="submit" value="註冊">
    </form>
</div>
<script>

</script>
@endsection
