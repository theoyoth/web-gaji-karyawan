<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Add this inside <head> -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        
        @vite('resources/css/app.css')

        <title>Gaji pegawai</title>
    </head>
    <body class="antialiased font-poppins bg-gray-300 relative overflow-hidden">
        <img src="/image/building.jpg" alt="building" class="absolute inset-0 z-[-10]">
        <div class="w-full bg-zinc-100 py-4">
            <div class="w-52 relative ml-10">
                <img loading="lazy" decoding="async" src="https://gunungselatan.com/wp-content/uploads/2025/03/header.png" alt="logo"
                class="w-full h-full object-contain" />
            </div>
        </div>
        <main class="px-4">
            @yield('content')
        </main>
    </body>
</html>