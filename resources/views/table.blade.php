@extends('layout.main')

@section('content')
    <div class="px-4">
        {{-- <div class="w-auto h-100 relative"> --}}
            <img loading="lazy" decoding="async" class="w-50 h-20" src="https://gunungselatan.com/wp-content/uploads/2025/03/header.png" alt="logo" itemprop="image" srcset="https://gunungselatan.com/wp-content/uploads/2025/03/header.png 250w, https://gunungselatan.com/wp-content/uploads/2025/03/header-150x37.png 150w" sizes="auto, (max-width: 250px) 100vw, 250px" />
        {{-- </div> --}}
            
        <div>
            <h1 class="text-4xl font-bold text-center">DAFTAR GAJI KARYAWAN</h3>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-4">
            <a href={{ url('/create') }} class="px-4 py-2 rounded-lg bg-green-600">Create +</button>
        </div>
        <div class="card-body">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th rowspan="2" class="px-4 py-2 w-5 border border-gray-300 bg-gray-200">No.</th>
                        <th rowspan="2" class="px-4 py-2 border border-gray-300 bg-gray-200">Nama</th>
                        <th rowspan="2" class="px-4 py-2 border border-gray-300 bg-gray-200">Tempat, Tanggal Lahir</th>
                        <th rowspan="2" class="px-4 py-2 border border-gray-300 bg-gray-200">Tanggal diangkat</th>
                        
                        <!-- Gaji Pokok with 3 sub-columns -->
                        <th rowspan="2" class="px-4 py-2 border border-gray-300 bg-gray-200 text-center">Gaji Pokok</th>
                        
                        <!-- Tunjangan -->
                        <th colspan="3" class="px-4 py-2 border border-gray-300 bg-gray-200">Tunjangan</th>
                        
                        <!-- Jumlah Kotor -->
                        <th rowspan="2" class="px-4 py-2 border border-gray-300 bg-gray-200">Jumlah Kotor</th>
                        
                        <!-- Potongan with 3 sub-columns -->
                        <th colspan="3" class="px-4 py-2 border border-gray-300 bg-gray-200 text-center">Potongan</th>
                        
                        <!-- Jumlah Bersih -->
                        <th rowspan="2" class="px-4 py-2 border border-gray-300 bg-gray-200">Jumlah Bersih</th>
                        
                        <!-- TTD -->
                        <th rowspan="2" class="px-4 py-2 border border-gray-300 bg-gray-200">TTD</th>
                    </tr>
                    <tr>
                        <!-- Sub-columns for tunjangan -->
                        <th class="px-4 py-2 border border-gray-300 bg-gray-200">Makan</th>
                        <th class="px-4 py-2 border border-gray-300 bg-gray-200">Hari tua</th>
                        <th class="px-4 py-2 border border-gray-300 bg-gray-200">Retase</th>
                        
                        <!-- Sub-columns for Potongan -->
                        <th class="px-4 py-2 border border-gray-300 bg-gray-200">BPJS</th>
                        <th class="px-4 py-2 border border-gray-300 bg-gray-200">Tabungan hari tua</th>
                        <th class="px-4 py-2 border border-gray-300 bg-gray-200">Kredit/kasbon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-2 border border-gray-300">{{ $user->id }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->nama}}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->tempat_tanggal_lahir}}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->tanggal_diangkat}}</td>
                            
                            <td class="px-4 py-2 border border-gray-300">{{$user->gaji_pokok}}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->tunjangan_makan}}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->tunjangan_hari_tua}}</td>
                            
                            <td class="px-4 py-2 border border-gray-300">{{$user->tunjangan_retase}}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->jumlah_kotor}}</td>
                            
                            <td class="px-4 py-2 border border-gray-300">{{$user->potongan_BPJS}}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->potongan_tabungan_hari_tua}}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->potongan_kredit_kasbon}}</td>
                            
                            <td class="px-4 py-2 border border-gray-300">{{ $user->jumlah_bersih }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{$user->ttd}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
