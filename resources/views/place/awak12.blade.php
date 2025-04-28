@extends('layout.main')

@section('content')
        <div class="min-h-screen">
            <img src="/image/pattern-bw.jpg" alt="building" class="fixed top-0 left-0 -z-[10] opacity-10 h-screen w-full object-cover">
            <div class="bg-zinc-100 rounded-lg mt-4 px-1 pt-4 min-h-screen min-w-screen backdrop-blur-md bg-white/65 border border-white/30 shadow-lg">
                <div>
                    <h1 class="text-4xl font-bold text-center">DAFTAR :  GAJI KARYAWAN TRANSPORTIR AWAK 1 DAN AWAK 2</h3>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-center">BULAN : {{ $month ?? '' }} {{ $year ?? '' }}</h3>
                </div>
                @if(session('success'))
                    <div id="success-msg" class="bg-green-100 text-green-800 p-2 rounded">
                        {{ session('success') }}
                    </div>
                    <script>
                    setTimeout(() => {
                        const msg = document.getElementById('success-msg');
                        if (msg) msg.style.display = 'none';
                    }, 4000);
                    </script>
                @endif
                <div class="w-full flex justify-between">
                    <a href="{{ route('header.index') }}" class="inline-block my-4 px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800"><- kembali</a>
                    <div class="flex gap-4">
                        <a href="{{ route('user.create') }}" class="inline-block my-4 px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Buat baru +</a>
                        <a href="{{ route('print.awak12') }}" class="inline-block my-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Print Dokumen 📄</a>
                    </div>
                </div>
                <form method="GET" action="{{ route('filter.awak12') }}" class="mb-4">
                    <select name="bulan" required class="px-4 py-2 shadow-md">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                            <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                        @endforeach
                    </select>
                    <select name="tahun" required class="px-4 py-2 shadow-md">
                        <option value="">-- Pilih Tahun --</option>
                        @for ($y = 2020; $y <= now()->year; $y++)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600  border">Filter</button>
                </form>
                <div class="bg-gray-100">
                    @if($users->flatMap->salaries->isNotEmpty())
                        <!-- your table -->
                    @else
                        <p class="text-red-500 py-2 bg-gray-100 indent-2">Tidak ada data gaji untuk bulan dan tahun yang dipilih.</p>
                    @endif
                    <table class="min-w-full table-auto border-collapse text-[0.8rem]">
                        <thead>
                            <tr>
                                <th rowspan="2" class="py-2 w-5 border border-black bg-gray-500">No.</th>
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[180px]">Nama</th>
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[150px]">Tempat, Tanggal Lahir</th>
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[140px]">Tanggal diangkat</th>
                                <!-- Gaji Pokok with 3 sub-columns -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 text-center">Gaji Pokok</th>
                                <!-- Tunjangan -->
                                <th colspan="3" class="py-2 border border-black bg-gray-500">Tunjangan</th>
                                <!-- Jumlah Kotor -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500">Jumlah Kotor</th>
                                <!-- Potongan with 3 sub-columns -->
                                <th colspan="3" class="py-2 border border-black bg-gray-500 text-center">Potongan</th>
                                <!-- Jumlah Bersih -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500">Jumlah Bersih</th>
                                <!-- TTD -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[60px]">TTD</th>
                                <th rowspan="2" class="py-2 border border-black bg-gray-500"></th>
                            </tr>
                            <tr>
                                <!-- Sub-columns for tunjangan -->
                                <th class="py-2 border border-black bg-gray-500 w-[120px]">Makan</th>
                                <th class="py-2 border border-black bg-gray-500 w-[120px]">Hari tua</th>
                                <th class="py-2 border border-black bg-gray-500 w-[120px]">Retase</th>
                                <!-- Sub-columns for Potongan -->
                                <th class="py-2 border border-black bg-gray-500 w-[120px]">BPJS</th>
                                <th class="py-2 border border-black bg-gray-500 w-[120px]">Tabungan hari tua</th>
                                <th class="py-2 border border-black bg-gray-500">Kredit/kasbon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($users as $user)
                                @foreach ($user->salaries as $salary)
                                    <tr>
                                        <td class="text-center py-2 border border-gray-300">{{ $no++ }}</td>
                                        <td class="text-center py-2 border border-gray-300">{{$user->nama}}</td>
                                        <td class="text-center py-2 border border-gray-300">{{ $user->tempat_lahir . ', ' . $user->tanggal_lahir->format('d M Y') }}</td>
                                        <td class="text-center py-2 border border-gray-300">{{$user->tanggal_diangkat->format('d F Y')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->gaji_pokok, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->tunjangan_makan, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->tunjangan_hari_tua, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->tunjangan_retase, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->jumlah_kotor, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->potongan_bpjs, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->potongan_kredit_kasbon, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">Rp.{{number_format($salary->jumlah_bersih, 0, ',', '.')}}</td>
                                        <td class="text-center py-2 border border-gray-300">
                                            <img src="{{ asset('storage/ttd/' . $user->nama . '.png') }}" alt="{{ $user->nama }}" class="w-20 h-20 object-contain">
                                        </td>
                                        <td class="text-center px-1 py-2 border border-gray-300">
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 py-1 px-2 rounded">
                                                    <i class="fas fa-trash text-white"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
