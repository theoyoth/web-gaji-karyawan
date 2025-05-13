@extends('layout.main')

@section('content')
        <div class="min-h-screen w-full">
            <img src="/image/pattern-bw.jpg" alt="building" class="fixed top-0 left-0 -z-[10] opacity-10 h-screen min-w-full object-cover">
            <div class="bg-zinc-100 rounded-lg mt-4 px-1 pt-4 min-h-screen min-w-screen backdrop-blur-md bg-white/65 border border-white/30 shadow-lg overflow-scroll">
                <div>
                    <h1 class="text-4xl font-bold text-center">DAFTAR :  GAJI KARYAWAN KANTOR 1</h1>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-center">BULAN : {{ $month ?? '' }} {{ $year ?? '' }}</h1>
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
                        <a href="{{ route('user.createKantor', ['from' => 'kantor 1']) }}" class="inline-block my-4 px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Buat baru +</a>
                        <a href="{{ route('print.kantor1') }}" class="inline-block my-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Print Dokumen 📄</a>
                    </div>
                </div>
                <section class="flex justify-between items-start">
                  <form method="GET" action="{{ route('filter.kantor1') }}" class="mb-4">
                    <fieldset  class="border border-gray-300 p-2 rounded-md">
                      <legend class="text-xs">Filter</legend>
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
                    </fieldset>
                      {{-- Reset Filter Button --}}
                      @if(request('bulan') || request('tahun'))
                        <a href="{{ route('kantor1.index') }}" class="bg-gray-500 text-white px-4 py-2">Reset</a>
                      @endif
                  </form>
                  <form method="GET" action="{{ route('search.kantor') }}" class="mb-2">
                    <fieldset  class="border border-gray-300 p-2 rounded-md flex gap-x-2 items-center">
                      <legend class="text-xs">Search</legend>
                      <input type="hidden" name="kantor" value="kantor 1">
                      <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="outline-1 w-full px-2 py-2 border-2 border-gray-300 shadow-md"
                        placeholder="cari nama"
                      />
                      <button type="submit" class="px-4 py-2 text-white bg-blue-600 border">
                        cari
                      </button>
                    </fieldset>
                  </form>
                </section>
                <div class="bg-gray-100">
                    @if($users->isEmpty())
                        <!-- your table -->
                      <p class="text-red-500 py-2 bg-gray-100 indent-2">Tidak ada data karyawan yang ditemukan.</p>
                    @endif
                    <table class="min-w-full table-auto border-collapse text-[0.8rem]">
                        <thead>
                            <tr>
                              <th rowspan="2" class="py-2 w-5 border border-black bg-gray-500">No.</th>
                              <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[180px]">Nama</th>
                              <!-- Gaji Pokok with 3 sub-columns -->
                              <th rowspan="2" class="py-2 border border-black bg-gray-500 text-center">Gaji Pokok</th>
                              <!-- Tunjangan -->
                              <th class="py-2 border border-black bg-gray-500">Tunjangan</th>
                              <!-- Jumlah Kotor -->
                              <th rowspan="2" class="py-2 border border-black bg-gray-500">Jumlah Gaji</th>
                              <!-- Potongan with 3 sub-columns -->
                              <th colspan="3" class="py-2 border border-black bg-gray-500 text-center">Potongan</th>
                              <!-- Jumlah Bersih -->
                              <th rowspan="2" class="py-2 border border-black bg-gray-500">Jumlah Bersih</th>
                              <!-- TTD -->
                              <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[60px]">TTD</th>
                              <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[50px]"></th>
                            </tr>
                            <tr>
                              <!-- Sub-columns for tunjangan -->
                              <th class="py-2 border border-black bg-gray-500 w-[120px]">Makan</th>
                              {{-- <th class="py-2 border border-black bg-gray-500 w-[120px]">Hari tua</th> --}}

                              <!-- Sub-columns for Potongan -->
                              <th class="py-2 border border-black bg-gray-500 w-[120px]">BPJS</th>
                              <th class="py-2 border border-black bg-gray-500 w-[120px]">Tabungan hari tua</th>
                              <th class="py-2 border border-black bg-gray-500">Kredit/kasbon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($users as $user)
                              @if ($user->salary)
                                @php
                                    $salary = $user->salary;
                                @endphp
                                <tr>
                                  <td class="text-center py-1 border border-gray-500">{{ $no++ }}</td>
                                  <td class="text-center py-1 border border-gray-500 text-wrap uppercase">{{ $user->nama }}</td>
                                  {{-- <td class="text-center py-1 border border-gray-500">{{ $user->tempat_lahir . ', ' . $user->tanggal_lahir->format('d M Y') }}</td>
                                  <td class="text-center py-1 border border-gray-500">{{ $user->tanggal_diangkat->format('d F Y') }}</td> --}}
                                  <td class="text-center py-1 border border-gray-500">Rp{{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                                  <td class="text-center py-1 border border-gray-500">Rp{{ number_format($salary->tunjangan_makan, 0, ',', '.') }}</td>
                                  {{-- <td class="text-center py-1 border border-gray-500">Rp{{ number_format($salary->tunjangan_hari_tua, 0, ',', '.') }}</td> --}}
                                  <td class="text-center py-1 border border-gray-500">Rp{{ number_format($salary->jumlah_gaji, 0, ',', '.') }}</td>
                                  <td class="text-center py-1 border border-gray-500">Rp{{ number_format($salary->potongan_bpjs, 0, ',', '.') }}</td>
                                  <td class="text-center py-1 border border-gray-500">Rp{{ number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.') }}</td>
                                  <td class="text-center py-1 border border-gray-500">Rp{{ number_format($salary->potongan_kredit_kasbon, 0, ',', '.') }}</td>
                                  <td class="text-center py-1 border border-gray-500">Rp{{ number_format($salary->jumlah_bersih, 0, ',', '.') }}</td>
                                  <td class="text-center py-1 border border-gray-500">
                                    <img src="{{ asset('storage/ttd/' . $user->nama . '.png') }}" alt="{{ 'ttd' . $user->nama }}" class="ttd w-20 h-20 object-contain">
                                  </td>
                                  <td class="text-center px-1 py-1 border border-gray-500">
                                    <div class="flex flex-col gap-1 items-center">
                                      <a href="{{ route('edit.kantor', ['user'=>$user->id, 'page'=>request()->get('page',1)]) }}" class="bg-blue-500 rounded py-1 px-2"><i class="fa fa-edit text-white"></i></a>
                                      <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="bg-red-500 py-1 px-2 rounded">
                                          <i class="fas fa-trash text-white"></i>
                                      </button>
                                      </form>
                                    </div>
                                  </td>
                                </tr>
                              @endif
                            @endforeach
                            {{-- total each page pagination --}}
														<tr>
															<td class="text-center border border-gray-500"></td>
															<td colspan="2" class="border-b border-gray-500"><strong>TOTAL PER HALAMAN</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($pageTotals['totalTunjanganMakan'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($pageTotals['totalJumlahGaji'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($pageTotals['totalPotonganBpjs'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($pageTotals['totalPotonganHariTua'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($pageTotals['totalPotonganKreditKasbon'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($pageTotals['totalGeneral'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"></td>
															<td class="text-center border border-gray-500"></td>
														</tr>
                            {{-- total all users salary --}}
														<tr class="text-lg bg-emerald-300 text-gray-900 font-semibold">
															<td class="text-center border border-gray-500"></td>
															<td colspan="2" class="border-b border-gray-500"><strong>TOTAL SEMUA</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($totalUsersSalary['totalTunjanganMakan'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($totalUsersSalary['totalJumlahGaji'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($totalUsersSalary['totalPotonganBpjs'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($totalUsersSalary['totalPotonganHariTua'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($totalUsersSalary['totalPotonganKreditKasbon'], 0) }}</strong></td>
															<td class="text-center border border-gray-500"><strong>Rp{{ number_format($totalUsersSalary['totalGeneral'], 0) }}</strong></td>
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
