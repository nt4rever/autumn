<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Autumn</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
    <main class="py-4">
        @yield('content')
    </main>
</body>

</html>
