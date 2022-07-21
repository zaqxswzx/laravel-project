@extends('layouts.app')
@section('content')

<div id="app">
    <login-component></login-component>
</div>
<script>
    const app = new Vue({
        el: '#app'
    });
</script>
@endsection
