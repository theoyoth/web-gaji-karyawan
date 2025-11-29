
@extends('layout.main')

@section('content')
  <div>
    <div class="bg-zinc-100 rounded-md h-[50px] flex items-center justify-between px-1 ">
      <a href="{{ route('home') }}" class="max-w-max flex items-center bg-zinc-800 text-white rounded-md hover:bg-zinc-900 px-4 py-1"><i class="fas fa-arrow-left text-sm mr-2 text-zinc-100"></i>kembali</a>
      {{-- <a href="{{ route('export.awak12', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
        class="flex items-center bg-green-600 text-gray-200 rounded-md hover:bg-green-700 px-4 py-1">
          <i class="fas fa-file-excel mr-2"></i>Excel
      </a> --}}
    </div>
    <div class="bg-zinc-100 rounded-lg mt-4 px-1 pt-4 min-h-screen backdrop-blur-md bg-white/65 border border-white/30 shadow-lg">
        {{-- <div>
            <h1 class="text-4xl font-bold text-center">DAFTAR :  GAJI KARYAWAN KANTOR 2</h3>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-center">BULAN : {{ $month ?? '' }} {{ $year ?? '' }}</h3>
        </div> --}}
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
        <section class="flex justify-between items-center">
          {{-- <form method="GET" action="{{ route('filter.kantor2') }}" class="mb-4">
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
              <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded border">Filter</button>
            </fieldset> --}}
              {{-- Reset Filter Button --}}
              {{-- @if(request('bulan') || request('tahun'))
                <a href="{{ route('kantor2.index') }}" class="bg-gray-500 text-white px-4 py-2">Reset</a>
              @endif
          </form> --}}
          <form method="GET" action="{{ route('search.kantor') }}" class="flex gap-2">
            <input type="hidden" name="kantor" value="kantor 2">
            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
            <input
              type="text"
              name="search"
              value="{{ request('search') }}"
              class="outline-1 w-full px-2 py-1 border border-gray-200 rounded-md"
              placeholder="cari nama"
            />
            <button type="submit" class="px-4 py-1 text-white bg-zinc-800 hover:bg-zinc-900 rounded-md">
              cari
            </button>
          </form>
          <div class="flex gap-4">
            <a href="{{ route('employee.createKantor', ['from' => 'kantor 2','bulan' => request('bulan'),'tahun' => request('tahun')]) }}" class="flex items-center my-4 px-4 py-1 bg-zinc-800 text-white rounded-md hover:bg-zinc-900"><i class="fas fa-plus mr-2"></i>Buat baru</a>
            <a href="{{ route('print.kantor2.filtered',['bulan' => request('bulan'),'tahun' => request('tahun'),'kantor' => 'kantor 1']) }}" class="bg-zinc-100 border border-zinc-800 flex items-center my-4 px-4 py-1 text-zinc-900 rounded-md hover:bg-zinc-200"><i class="fas fa-print mr-2"></i>Print Dokumen</a>

            {{-- <a href="{{ route('print.excel.awak12') }}" class="flex items-center my-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"><i class="fas fa-file-excel mr-2"></i>Export</a> --}}
          </div>
        </section>
        @php
          $months = [
              'Januari',
              'Februari',
              'Maret',
              'April',
              'Mei',
              'Juni',
              'Juli',
              'Agustus',
              'September',
              'Oktober',
              'November',
              'Desember',
          ];
        @endphp
        <div class="flex flex-wrap space-x-2 border-b border-b-gray-300 border-t border-gray-300 py-2">
          {{-- Loop through months --}}
          @foreach ($months as $name)
            <a href="{{ route('filterbymonth.kantor', ['bulan' => $name, 'tahun' => 2025, 'kantor' => 'kantor 2']) }}"
              class="text-sm px-4 py-1 border rounded hover:shadow-md {{ request('bulan') == $name ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-800' }}">
                <i class="fas fa-calendar-alt text-sm mr-1"></i>
                {{ $name }}
            </a>
          @endforeach
        </div>
        <div class="bg-gray-100">
            @if($employees->isEmpty())
                <!-- your table -->
              <p class="text-red-500 py-1 bg-zinc-200 indent-2 rounded-md my-2">Tidak ada data karyawan yang ditemukan.</p>
            @endif
            <table class="min-w-full table-auto border-collapse text-[0.8rem]">
                <thead class="text-zinc-900">
                  <tr>
                    <th rowspan="2" class="py-2 w-5 border border-zinc-300 bg-zinc-100">No.</th>
                    <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 w-[200px]">Nama</th>
                    <th  class="py-2 border border-zinc-300 bg-zinc-100 w-[150px]">Masuk kerja</th>
                    <!-- Gaji Pokok with 3 sub-columns -->
                    <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 text-center">Gaji Pokok (Rp.)</th>
                    <th  class="py-2 border border-zinc-300 bg-zinc-100 text-center">Hari Kerja</th>
                    <!-- Tunjangan -->

                    <th class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]">Uang Makan (Rp.)</th>
                    <!-- Jumlah Kotor -->
                    <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100">Total Gaji (Rp.)</th>
                    <!-- Potongan with 3 sub-columns -->
                    <th class="py-2 border border-zinc-300 bg-zinc-100">Kredit/kasbon (Rp.)</th>
                    <th class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]">BPJS (Rp.)</th>
                    {{-- <th class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]">Tabungan hari tua</th> --}}
                    <!-- Jumlah Bersih -->
                    <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100">Jumlah Gaji Bersih (Rp.)</th>
                    <!-- TTD -->
                    <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 w-[60px]">TTD</th>
                    <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 w-[50px]"></th>
                  </tr>
                  <tr>
                    <!-- Sub-columns for tunjangan -->

                    {{-- <th class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]">Hari tua</th> --}}

                    <!-- Sub-columns for Potongan -->

                  </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($employees as $employee)
                        @if ($employee->salary)
                          @php
                            $salary = $employee->salary;
                          @endphp
                          <tr class="text-zinc-900 hover:bg-zinc-200/50">
                            <td class="text-center py-1 border border-zinc-300">{{ $no++ }}</td>
                            <td class="text-left py-1 border border-zinc-300 text-wrap w-[250px]">
                              <div class="flex items-center gap-2">
                              @if ($employee->foto_profil)
                                <img src="{{ asset('storage/' . $employee->foto_profil) }}" alt="Foto Profil" class="w-[50px] h-[70px] object-cover">
                              @endif
                              {{ $employee->nama }}
                            </div>
                            </td>
                            {{-- <td class="text-center py-1 border border-zinc-300">{{ $employee->tempat_lahir . ', ' . $employee->tanggal_lahir->format('d M Y') }}</td> --}}
                            <td class="text-center py-1 border border-zinc-300">{{ $employee->tanggal_diangkat }}</td>
                            <td class="text-center py-1 border border-zinc-300">{{ number_format($salary->gaji_pokok, 0, ',', '.') ?: '' }}</td>
                            <td class="text-center py-1 border border-zinc-300">{{ $salary->hari_kerja }}</td>
                            <td class="text-center py-1 border border-zinc-300">{{ number_format($salary->tunjangan_makan, 0, ',', '.') ?: '' }}</td>
                            {{-- <td class="text-center py-1 border border-zinc-300">{{ number_format($salary->tunjangan_hari_tua, 0, ',', '.') }}</td> --}}
                            <td class="text-center py-1 border border-zinc-300">{{ number_format($salary->jumlah_gaji, 0, ',', '.') ?: '' }}</td>
                            <td class="text-center py-1 border border-zinc-300">{{ number_format($salary->potongan_kredit_kasbon, 0, ',', '.') ?: '' }}</td>
                            <td class="text-center py-1 border border-zinc-300">{{ number_format($salary->potongan_bpjs, 0, ',', '.') ?: '' }}</td>
                            {{-- <td class="text-center py-1 border border-zinc-300">{{ number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.') }}</td> --}}
                            <td class="text-center py-1 border border-zinc-300">{{ number_format($salary->jumlah_bersih, 0, ',', '.') ?: '' }}</td>
                            <td class="text-center py-1 border border-zinc-300">
                              @if ($salary->ttd && file_exists(public_path('storage/ttd' . $salary->ttd)) )
                                <img src="{{ asset('storage/ttd/' . $employee->nama . '.png') }}" alt="{{ 'ttd' . $employee->nama }}" class="ttd w-20 h-20 object-contain">
                              @else
                                <p>-</p>
                              @endif
                            </td>
                            <td class="text-center px-1 py-1 border border-zinc-300">
                              <div class="flex flex-col gap-1 items-center">
                                <a href="{{ route('edit.kantor', ['employeeId'=> $employee->id,'employeeSalaryId'=>$salary->id, 'from' => 'kantor 2', 'page' =>request()->get('page',1)]) }}" class="bg-blue-500 rounded py-1 px-2"><i class="fa fa-edit text-white"></i></a>
                                <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
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
                    <tr class="text-zinc-900">
                      <td class="text-center border border-zinc-300"></td>
                      <td colspan="2" class="border-b border-zinc-300"><strong>TOTAL PER HALAMAN</strong></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalGajiPokok'], 0) ?: '' }}</strong></td>
                      <td class="text-center border-b border-zinc-300"></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalTunjanganMakan'], 0) ?: '' }}</strong></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalJumlahGaji'], 0) ?: '' }}</strong></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalPotonganKreditKasbon'], 0) ?: '' }}</strong></td>
                      {{-- <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalPotonganHariTua'], 0) }}</strong></td> --}}
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalPotonganBpjs'], 0) ?: '' }}</strong></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalGeneral'], 0) ?: '' }}</strong></td>
                      <td class="text-center border border-zinc-300"></td>
                      <td class="text-center border border-zinc-300"></td>
                    </tr>
                    {{-- total all employees salary --}}
                    <tr class="text-lg bg-zinc-100 text-zinc-900 font-semibold">
                      <td class="text-center border border-zinc-300"></td>
                      <td colspan="2" class="border-b border-zinc-300"><strong>TOTAL SEMUA</strong></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalGajiPokok'], 0) ?: '' }}</strong></td>
                      <td class="text-center border-b border-zinc-300"></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalTunjanganMakan'], 0) ?: '' }}</strong></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalJumlahGaji'], 0) ?: '' }}</strong></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalPotonganKreditKasbon'], 0) ?: '' }}</strong></td>
                      {{-- <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalPotonganHariTua'], 0) }}</strong></td> --}}
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalPotonganBpjs'], 0) ?: '' }}</strong></td>
                      <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalGeneral'], 0) ?: '' }}</strong></td>
                      <td class="text-center border border-zinc-300"></td>
                      <td class="text-center border border-zinc-300"></td>
                    </tr>
                </tbody>
            </table>
            <!-- Tailwind-styled pagination -->
            <div class="mt-4 flex justify-center">
              {{ $employees->links() }}
            </div>
        </div>
    </div>
  </div>
@endsection
