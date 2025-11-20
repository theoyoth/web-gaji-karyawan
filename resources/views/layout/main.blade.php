<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Add this inside <head> -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <title>Gaji pegawai</title>
    </head>
    <body class="antialiased font-poppins relative">
      @auth
        <div class="flex justify-between items-center px-10">
          <div class="w-52 relative">
              <img loading="lazy" decoding="async" src="https://gunungselatan.com/wp-content/uploads/2025/03/header.png" alt="logo"
              class="w-full h-full object-contain" />
          </div>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            
            <button class="max-w-max flex items-center my-4 px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-800"><i class="fa fa-sign-out-alt text-lg text-gray-100 mr-1"></i>Logout</button>
          </form>
        </div>
      @endauth
        <main class="px-4">
            @yield('content')
        </main>
    </body>
</html>