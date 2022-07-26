<html>
    <head>
        <link rel="stylesheet" href="/css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    </head>
    <body>
        @include('layouts.admin_nav')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
