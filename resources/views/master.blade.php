<html>
    <head>
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Tasks Management - @yield('title')</title>
    </head>
    <body class="bg-gray-100">
        <div>
            <div class="my-8 flex justify-center">
                <a href="/">
                    <img src="/logo_tasks.png" alt="">
                </a>
            </div>
            @yield('content')
        </div>
    </body>

    @include('footer')
</html>