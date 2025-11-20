@extends('layout.main')

@section('content')
  <div class="flex justify-center items-center h-[90vh]">
    <img src="/image/building.jpg" alt="building" class="absolute inset-0 -z-[10] h-screen w-full object-cover">
    <div class="w-1/3 rounded-lg h-1/2 p-10 relative overflow-hidden backdrop-blur-sm bg-white/50 border-2 border-zinc-200 shadow-lg grid place-items-center">
        <div class="w-full">
          <h1 class="text-center font-bold text-4xl text-zinc-950">LOGIN</h1>
          <form action="{{ route('auth.login') }}" method="POST" class="mt-6 w-full flex flex-col items-center gap-4">
            @csrf
            <div class="w-1/2">
              <input type="text" placeholder="username" required name="username" class="px-2 py-2 w-full rounded focus:outline focus:outline-zinc-900 focus:outline-2 placeholder:text-sm">
            </div>
            <div class="w-1/2">
              <input type="password" placeholder="password" required name="password" class="px-2 py-2 w-full rounded focus:outline focus:outline-zinc-900 focus:outline-2 placeholder:text-sm">
            </div>
            {{-- error message --}}
            @if ($errors->any())
                <p class="text-red-600 text-sm">{{ $errors->first() }}</p>
            @endif

            <button type="submit" class="w-1/2 px-2 py-2 rounded bg-zinc-900 hover:bg-zinc-950 text-zinc-200">Masuk</button>
          </form>
        </div>
      </div>
  </div>
@endsection