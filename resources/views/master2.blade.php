<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('style')
</head>
<body>
    <div id="app">
		<a-layout>
            <a-layout-content id="content" style="background:url('../../images/nen_vstk.jpg')">@yield('content')</a-layout-content>
        </a-layout>
    </div>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script>
        var height = window.screen.height;
        var content = document.getElementById('content');
        content.style.height = (height-100)+'px';
    </script>
    @yield('script')
</body>
</html>