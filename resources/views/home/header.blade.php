@extends('layout.main')

@section('content')
<div class="flex justify-center items-center h-[90vh]">
        <img src="/image/building.jpg" alt="building" class="absolute inset-0 -z-[10] h-screen w-full object-cover">
        <div class="bg-zinc-100 w-2/3 rounded-lg h-3/4 p-10 relative overflow-hidden backdrop-blur-md bg-white/50 border border-white/30 shadow-lg">
            <div class="relative z-10">
                <div>
                    <h1 class="text-4xl font-bold text-center">DAFTAR :  GAJI KARYAWAN PT. GUNUNG SELATAN</h3>
                </div>
                <div class="w-full m-auto">
                    <div class="flex gap-4">
                      @php
                        $monthName = \Carbon\Carbon::now()->translatedFormat('F');
                      @endphp
                        <a href="{{ route('awak12.index',['bulan' => $monthName, 'tahun' => 2025, 'page' => 1]) }}" class="my-4 w-[200px] h-[100px] flex flex-col items-center justify-center bg-gray-700 text-white text-center rounded-md hover:bg-gray-800">
                            <div class="text-blue-500 text-4xl mb-2">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="text-center font-semibold text-white">AWAK 1 & AWAK 2</div>
                        </a>
                        <a href="{{ route('filterbymonth.kantor',['bulan' => $monthName ,'tahun' => 2025,'kantor' => 'kantor 1']) }}" class="my-4 w-[200px] h-[100px] flex items-center justify-center bg-gray-700 text-white text-center rounded-md hover:bg-gray-800">
                            <div class="text-green-500 text-4xl mb-2">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="text-center font-semibold text-white ml-2">KANTOR 1</div>
                        </a>
                        <a href="{{ route('filterbymonth.kantor',['bulan' => $monthName ,'tahun' => 2025,'kantor' => 'kantor 2']) }}" class="my-4 w-[200px] h-[100px] flex items-center justify-center bg-gray-700 text-white text-center rounded-md hover:bg-gray-800">
                            <div class="text-purple-500 text-4xl mb-2">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="text-center font-semibold text-white ml-2">KANTOR 2</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
