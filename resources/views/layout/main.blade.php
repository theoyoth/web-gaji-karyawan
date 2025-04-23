<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Add this inside <head> -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

        @vite('resources/css/app.css')

        <title>Gaji pegawai</title>
    </head>
    <body class="antialiased font-poppins">
        @yield('content')
    </body>
</html>