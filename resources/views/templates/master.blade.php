<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>user-manager | @yield('pageName') </title>

        @yield('view-css')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        @include('templates.menu')
        <div id="content-wrapper">
            @yield('view-content')
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
        @yield('view-js')
    </body>
</html>
