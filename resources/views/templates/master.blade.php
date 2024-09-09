<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>user-manager | @yield('page-title') </title>

        @yield('view-css')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,600&display=swap" rel="stylesheet">
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
