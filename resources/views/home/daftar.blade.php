@extends('layout.main')

@section('content')
    <div class="px-4">
        {{-- <div class="w-auto h-100 relative"> --}}
            <img loading="lazy" decoding="async" class="w-50 h-20" src="https://gunungselatan.com/wp-content/uploads/2025/03/header.png" alt="logo" itemprop="image" srcset="https://gunungselatan.com/wp-content/uploads/2025/03/header.png 250w, https://gunungselatan.com/wp-content/uploads/2025/03/header-150x37.png 150w" sizes="auto, (max-width: 250px) 100vw, 250px" />
        {{-- </div> --}}
            
        <div>
            <h1 class="text-4xl font-bold text-center">DAFTAR :  GAJI KARYAWAN PT. GUNUNG SELATAN</h3>
        </div>
    </div>
    <div class="w-1/2 m-auto">
        <a href="{{ route('user.create') }}" class="inline-block my-4 px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">DAFTAR GAJI BARU+</a>
        <div>
            <a href="{{ route('awak12.index') }}" class="inline-block my-4 px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">AWAK 1 DAN AWAK 2</a>
            <a href="{{ route('kantor1.index') }}" class="inline-block my-4 px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">KANTOR 1</a>
            <a href="{{ route('kantor2.index') }}" class="inline-block my-4 px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">KANTOR 2</a>
        </div>
    </div>
@endsection
