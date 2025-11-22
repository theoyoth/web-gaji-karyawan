<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Add this inside <head> -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <title>GS - karyawan</title>
    </head>
    <body class="antialiased font-poppins relative bg-zinc-200">
        <main class="p-4">
            @yield('content')
        </main>
    </body>
</html>