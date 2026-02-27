@extends('layout.main')

@section('content')
  @auth
    <div class="w-screen fixed top-0 left-0 flex justify-between items-center px-5">
      <div class="w-16 relative shadow-md">
          {{-- <img loading="lazy" decoding="async" src="https://gunungselatan.com/wp-content/uploads/2025/03/header.png" alt="logo"
          class="w-full h-full object-contain" /> --}}
          <img loading="lazy" decoding="async" src="/image/gunsel.jpg" alt="logo"
          class="w-full h-full" />
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        
        <button class="max-w-max flex items-center my-4 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 shadow-md"><i class="fa fa-sign-out-alt text-lg text-gray-100 mr-1"></i>Logout</button>
      </form>
    </div>  
  @endauth
  <div class="flex justify-center items-center h-[90dvh]">
    <img src="/image/building.jpg" alt="building" class="absolute inset-0 -z-[10] h-screen w-full object-cover">
    <div class="w-2/3 rounded-lg h-[50vh] p-10 relative overflow-hidden backdrop-blur-sm bg-white/50 border-2 border-zinc-200 shadow-lg">
      <div class="relative z-10">
        <div>
            <h1 class="text-4xl font-bold text-center text-zinc-950">DAFTAR :  GAJI KARYAWAN PT. GUNUNG SELATAN</h3>
        </div>
        <div class="w-full m-auto">
            <div class="flex gap-4">
              @php
                $monthName = now()->translatedFormat('F');
                $currentYear = now()->year;
              @endphp
                <a href="{{ route('awak12.index',['bulan' => $monthName, 'tahun' => $currentYear, 'page' => 1]) }}" class="my-4 w-[200px] h-[100px] flex flex-col items-center justify-center bg-gray-900 text-white text-center rounded-md hover:bg-gray-950 border-2 border-zinc-200">
                    <div class="text-blue-500 text-4xl mb-2">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="text-center font-semibold text-white">AWAK 1 & AWAK 2</div>
                </a>
                <a href="{{ route('filterbymonth.kantor',['bulan' => $monthName ,'tahun' => $currentYear,'kantor' => 'kantor 1']) }}" class="my-4 w-[200px] h-[100px] flex items-center justify-center bg-gray-900 text-white text-center rounded-md hover:bg-gray-950 border-2 border-zinc-200">
                    <div class="text-green-500 text-4xl mb-2">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="text-center font-semibold text-white ml-2">KANTOR 1</div>
                </a>
                <a href="{{ route('filterbymonth.kantor',['bulan' => $monthName ,'tahun' => $currentYear,'kantor' => 'kantor 2']) }}" class="my-4 w-[200px] h-[100px] flex items-center justify-center bg-gray-900 text-white text-center rounded-md hover:bg-gray-950 border-2 border-zinc-200">
                    <div class="text-purple-500 text-4xl mb-2">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="text-center font-semibold text-white ml-2">KANTOR 2</div>
                </a>
                {{-- <a href="{{ route('filterbymonth.kantor',['bulan' => $monthName ,'tahun' => 2025,'kantor' => 'operator,helper,supir']) }}" class="my-4 w-[200px] h-[100px] flex flex-col items-center justify-center bg-gray-700 text-white text-center rounded-md hover:bg-gray-800">
                    <div class="text-orange-500 text-4xl mb-2">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="text-center font-semibold text-white text-sm">OPERATOR, HELPER, & SUPIR</div>
                </a> --}}
            </div>
        </div>
      </div>
    </div>
  </div>
  <p class="absolute bottom-0 left-1/2 text-zinc-100 -translate-x-1/2">&copy; {{ date('Y') }} PT Gunung Selatan. All rights reserved.</p>
@endsection
