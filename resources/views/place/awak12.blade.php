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
                        <a href="{{ route('user.createAwak12') }}" class="inline-block my-4 px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Buat baru +</a>
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

                    {{-- Reset Filter Button --}}
                    @if(request('bulan') || request('tahun'))
                      <a href="{{ route('awak12.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Reset</a>
                    @endif
                </form>
                <div class="bg-gray-100">
                    @if($users->filter(fn($user) => $user->salary)->isNotEmpty())
                        <!-- do nothing -->
                    @else
                        <p class="text-red-500 py-2 bg-gray-100 indent-2">Tidak ada data gaji untuk bulan dan tahun yang dipilih.</p>
                    @endif
                    <table class="min-w-full table-auto border-collapse text-[0.8rem]">
                        <thead>
                            <tr>
                                <th rowspan="2" class="py-2 w-5 border border-black bg-gray-500">No.</th>
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[120px]">Nama</th>
                                <!-- Gaji Pokok with 3 sub-columns -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 text-center">Gaji Pokok</th>
                                <!-- hari kerja -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 text-center">Hari Kerja</th>
                                <!-- jumlah retase -->
                                <th colspan="2" class="py-2 border border-black bg-gray-500 text-center">Jumlah Retase</th>
                                <!-- tarif retase -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 text-center">Tarif Retase</th>
                                <!-- Tunjangan -->
                                <th class="py-2 border border-black bg-gray-500">Tunjangan</th>
                                <!-- jumlah ur -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500">Jumlah UR</th>
                                <!-- Jumlah Kotor -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500">Jumlah Gaji</th>
                                <!-- Potongan with 3 sub-columns -->
                                <th colspan="3" class="py-2 border border-black bg-gray-500 text-center">Potongan</th>
                                <!-- Jumlah Bersih -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500">Jumlah Bersih</th>
                                <!-- TTD -->
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[50px]">TTD</th>
                                <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[50px]"></th>
                            </tr>
                            <tr>
                                <!-- Sub-columns jumlah retase -->
                                <th class="py-2 border border-black bg-gray-500 w-[120px]"></th>
                                <th class="py-2 border border-black bg-gray-500 w-[150px]"></th>
                                <!-- Sub-columns for tunjangan -->
                                <th class="py-2 border border-black bg-gray-500 w-[120px]">Makan</th>
                                <!-- Sub-columns for Potongan -->
                                <th class="py-2 border border-black bg-gray-500 w-[120px]">BPJS</th>
                                <th class="py-2 border border-black bg-gray-500 w-[120px]">Tabungan hari tua</th>
                                <th class="py-2 border border-black bg-gray-500">Kredit/kasbon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($users as $user)
                                @if($user->salary)
                                    @php
                                        $salary = $user->salary;
                                        $deliveryCount = $salary->deliveries->count();
                                    @endphp
                                    @foreach ($salary->deliveries as $index => $delivery)
																			<tr>
																				@if($index === 0)
																					<td rowspan="{{ $deliveryCount }}" class="text-center border border-gray-500">{{ $no++ }}</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center border border-gray-500 uppercase">{{$user->nama}}</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center border border-gray-500">Rp{{number_format($salary->gaji_pokok, 0, ',', '.')}}</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center border border-gray-500">{{$salary->hari_kerja}}</td>
																				@endif
																				<td class="text-center py-1 border border-gray-500">{{ $delivery->jumlah_retase }}</td>
																				<td class="text-center py-1 border border-gray-500">{{ $delivery->kota }}</td>
																				<td class="text-center py-1 border border-gray-500">Rp{{ number_format($delivery->tarif_retase, 0, ',', '.') }}</td>
																				@if($index === 0)
																					<td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-gray-500">Rp{{number_format($salary->tunjangan_makan, 0, ',', '.')}}</td>
																				@endif
																					<td class="text-center py-1 border border-gray-500">Rp{{number_format($delivery->jumlah_ur, 0, ',', '.')}}</td>
																				@if($index === 0)
																					<td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-gray-500">Rp{{number_format($salary->jumlah_gaji, 0, ',', '.')}}</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-gray-500">Rp{{number_format($salary->potongan_bpjs, 0, ',', '.')}}</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-gray-500">Rp{{number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.')}}</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-gray-500">Rp{{number_format($salary->potongan_kredit_kasbon, 0, ',', '.')}}</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-gray-500">Rp{{number_format($salary->jumlah_bersih, 0, ',', '.')}}</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-gray-500">
																							<img src="{{ file_exists(public_path('storage/ttd/' . $user->nama . '.png')) ? asset('storage/ttd/' . $user->nama . '.png') : '' }}" alt="ttd" class="w-20 h-20 object-contain">
																					</td>
																					<td rowspan="{{ $deliveryCount }}" class="text-center border border-gray-500">
																						<div class="flex flex-col gap-1 items-center">
																							<a href="{{ route('edit.awak12', ['user' => $user->id, 'page' => request()->get('page', 1)]) }}" class="bg-blue-500 rounded py-1 px-2"><i class="fa fa-edit text-white"></i></a>
																							<form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
																								@csrf
																								@method('DELETE')
																								<button type="submit" class="bg-red-500 py-1 px-2 rounded">
																									<i class="fas fa-trash text-white"></i>
																								</button>
																							</form>
																						</div>
																					</td>
																				@endif
																			</tr>
                                    @endforeach
                                @endif
                            @endforeach
														<tr>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"><strong>Makan-{{ number_format($totalTunjanganMakan, 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Retase-{{ number_format($totalUpahRetase, 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Bersih-{{ number_format($totalJumlahBersih, 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>BPJS-{{ number_format($totalPotonganBPJS, 0) }}</strong></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"><strong>General-{{ number_format($totalGeneral, 0) }}</strong></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
														</tr>
                        </tbody>
                    </table>
                    <!-- Tailwind-styled pagination -->
                    <div class="mt-4 flex justify-center">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
@endsection
