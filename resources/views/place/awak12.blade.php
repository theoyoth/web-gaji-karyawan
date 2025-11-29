@extends('layout.main')

@section('content')
  <div>
    <div class="bg-zinc-100 rounded-md h-[50px] flex items-center justify-between px-1 ">
      <a href="{{ route('home') }}" class="max-w-max flex items-center bg-zinc-800 text-white rounded-md hover:bg-zinc-900 px-4 py-1"><i class="fas fa-arrow-left text-sm mr-2 text-zinc-100"></i>kembali</a>
    </div>
      <div class="bg-zinc-100 rounded-lg mt-4 px-1 pt-4 min-h-screen min-w-screen backdrop-blur-md bg-white/65 border border-white/30 shadow-lg">
        
        {{-- <div>
            <h1 class="text-4xl font-bold text-center">DAFTAR :  GAJI KARYAWAN TRANSPORTIR AWAK 1 DAN AWAK 2</h3>
            <h1 class="text-4xl font-bold text-center">DAFTAR :  GAJI TRANSPORTIR AWAK 1 & AWAK 2 PT. GUNUNG SELATAN</h3>
        </div> --}}
        {{-- <div>
            <h1 class="text-2xl font-bold text-center">BULAN : {{ $month ?? '' }} {{ $year ?? '' }}</h1>
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

          <section class="w-full flex justify-between items-center">
            <form method="GET" action="{{ route('search.awak12') }}" class="flex gap-2">
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
            <div class="flex items-center gap-4">
              <a href="{{ route('employee.createAwak12',['bulan' => request('bulan'),'tahun' => request('tahun')]) }}" class="flex items-center my-4 px-4 py-1 bg-zinc-800 text-white rounded-md hover:bg-zinc-900"><i class="fas fa-plus mr-2"></i>Buat baru</a>
              <a href="{{ route('print.awak12.filtered', ['bulan' => request('bulan'),'tahun' => request('tahun'),'kantor' => 'kantor 1']) }}" class="bg-zinc-100 border border-zinc-800 flex items-center my-4 px-4 py-1 text-zinc-900 rounded-md hover:bg-zinc-200"><i class="fas fa-print mr-2"></i>Print Dokumen</a>
              <a href="{{ route('export.awak12', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                class="flex items-center bg-green-600 text-zinc-200 rounded-md hover:bg-green-700 px-4 py-1">
                  <i class="fas fa-file-excel mr-2"></i>Excel
              </a>                    
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
              <a href="{{ route('awak12.index', ['bulan' => $name, 'tahun' => 2025, 'page' => 1]) }}" class="text-sm px-4 py-1 border rounded hover:shadow-md {{ request('bulan') == $name ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-800' }}"><i class="fas fa-calendar-alt text-sm mr-1"></i>
                  {{ $name }}
              </a>
              @endforeach
          </div>

          <div>
              @if($employees->isEmpty())
                  <!-- do nothing -->
                <p class="text-red-500 py-1 indent-2 bg-zinc-200 rounded-md my-2">Tidak ada data karyawan yang ditemukan.</p>
              @endif
              <table class="min-w-full table-auto border-collapse text-[0.8rem]">
                  <thead class="text-zinc-900">
                      <tr>
                          <th rowspan="2" class="py-2 w-5 border border-zinc-300 bg-zinc-100">No.</th>
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]">Nama</th>
                          <!-- Gaji Pokok with 3 sub-columns -->
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 text-center">Gaji Pokok (Rp.)</th>
                          <!-- hari kerja -->
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 text-center">Hari Kerja</th>
                          <!-- jumlah retase -->
                          <th colspan="2" class="py-2 border border-zinc-300 bg-zinc-100 text-center">Jumlah Retase</th>
                          <!-- tarif retase -->
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 text-center">Tarif Retase</th>
                          <!-- Tunjangan makan -->
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100">Uang Makan (Rp.)</th>
                          <!-- jumlah ur -->
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100">Jumlah UR (Rp.)</th>
                          <!-- Jumlah Kotor -->
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100">Total Gaji (Rp.)</th>
                          <!-- Potongan with 3 sub-columns -->
                          <th colspan="2" class="py-2 border border-zinc-300 bg-zinc-100 text-center">Potongan</th>
                          <!-- Jumlah Bersih -->
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100">Jumlah Gaji Bersih (Rp.)</th>
                          <!-- TTD -->
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 w-[50px]">TTD</th>
                          <th rowspan="2" class="py-2 border border-zinc-300 bg-zinc-100 w-[50px]"></th>
                      </tr>
                      <tr>
                          <!-- Sub-columns jumlah retase -->
                          <th class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]"></th>
                          <th class="py-2 border border-zinc-300 bg-zinc-100 w-[150px]"></th>
                          <!-- Sub-columns for tunjangan -->
                          {{-- <th class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]">Makan (Rp.)</th> --}}
                          <!-- Sub-columns for Potongan -->
                          <th class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]">BPJS (Rp.)</th>
                          {{-- <th class="py-2 border border-zinc-300 bg-zinc-100 w-[120px]">Tabungan hari tua</th> --}}
                          <th class="py-2 border border-zinc-300 bg-zinc-100">Kredit/kasbon (Rp.)</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php $no = 1; @endphp
                      @foreach($employees as $employee)
                          @if($employee->salary)
                              @php
                                  $salary = $employee->salary;
                                  $deliveryCount = $salary->deliveries->count();
                              @endphp
                              @foreach ($salary->deliveries as $index => $delivery)
                                <tr class="text-zinc-900" data-employee="{{ $employee->id }}">
                                  @if($index === 0)
                                    <td rowspan="{{ $deliveryCount }}" class="text-center border border-zinc-300">{{ $no++ }}</td>
                                    <td rowspan="{{ $deliveryCount }}" class="text-left border border-zinc-300 text-wrap w-[250px]">
                                      <div class="flex items-center gap-2">
                                        @if ($employee->foto_profil)
                                          <img src="{{ asset('storage/' . $employee->foto_profil) }}" alt="Foto Profil" class="w-[50px] h-[70px] object-cover">
                                        @endif
                                        {{ $employee->nama }}
                                      </div>
                                    </td>
                                    <td rowspan="{{ $deliveryCount }}" class="text-center border border-zinc-300">{{number_format($salary->gaji_pokok, 0, ',', '.')}}</td>
                                    <td rowspan="{{ $deliveryCount }}" class="text-center border border-zinc-300">{{$salary->hari_kerja}}</td>
                                  @endif
                                  <td class="text-center py-1 border border-zinc-300">{{ $delivery->jumlah_retase }}</td>
                                  <td class="text-center py-1 border border-zinc-300">{{ $delivery->kota }}</td>
                                  <td class="text-center py-1 border border-zinc-300">{{ number_format($delivery->tarif_retase, 0, ',', '.') }}</td>
                                  @if($index === 0)
                                    <td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-zinc-300">{{number_format($salary->tunjangan_makan, 0, ',', '.') ?: ''}}</td>
                                  @endif
                                    <td class="text-center py-1 border border-zinc-300">{{number_format($delivery->jumlah_ur, 0, ',', '.')}}</td>
                                  @if($index === 0)
                                    <td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-zinc-300">{{number_format($salary->jumlah_gaji, 0, ',', '.') ?: ''}}</td>
                                    <td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-zinc-300">{{number_format($salary->potongan_bpjs, 0, ',', '.') ?: ''}}</td>
                                    {{-- <td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-zinc-300">{{number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.')}}</td> --}}
                                    <td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-zinc-300">{{number_format($salary->potongan_kredit_kasbon, 0, ',', '.') ?: ''}}</td>
                                    <td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-zinc-300">{{number_format($salary->jumlah_bersih, 0, ',', '.') ?: ''}}</td>
                                    <td rowspan="{{ $deliveryCount }}" class="text-center py-1 border border-zinc-300">
                                      @if ($salary->ttd && file_exists(public_path('storage/ttd' . $salary->ttd)))
                                        <img src="{{ file_exists(public_path('storage/ttd/' . $employee->nama . '.png')) ? asset('storage/ttd/' . $employee->nama . '.png') : '' }}" alt="ttd" class="w-20 h-20 object-contain">
                                      @else
                                        <p>-</p>
                                      @endif
                                    </td>
                                    <td rowspan="{{ $deliveryCount }}" class="text-center border border-zinc-300">
                                      <div class="flex flex-col gap-1 items-center">
                                        <a href="{{ route('edit.awak12', ['employeeId'=> $employee->id,'employeeSalaryId'=>$salary->id, 'page' => request('page',1)]) }}" class="bg-blue-500 rounded py-1 px-2"><i class="fa fa-edit text-white"></i></a>
                                        <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
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
                      {{-- total each page pagination --}}
                      <tr class="text-zinc-900">
                        <td class="text-center border border-zinc-300"></td>
                        <td class="border-b border-zinc-300"><strong>TOTAL PER HALAMAN</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalJumlahGaji'], 0) ?: '' }}</strong></td>
                        <td colspan="4" class="text-center border border-zinc-300"></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalTunjanganMakan'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalJumlahRetase'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalJumlahGaji'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalPotonganBpjs'], 0) ?: '' }}</strong></td>
                        {{-- <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalPotonganHariTua'], 0) }}</strong></td> --}}
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalPotonganKreditKasbon'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($pageTotals['totalGeneral'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"></td>
                        <td class="text-center border border-zinc-300"></td>
                      </tr>
                      @if ($totalEmployeesSalary)
                      {{-- total all employees salary --}}
                      <tr class="text-lg bg-zinc-100 text-zinc-900 font-semibold">
                        <td class="text-center border border-zinc-300"></td>
                        <td class="border-b border-zinc-300"><strong>TOTAL SEMUA</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalJumlahGaji'], 0) ?: '' }}</strong></td>
                        <td colspan="4" class="text-center border border-zinc-300"></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalTunjanganMakan'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalJumlahRetase'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalJumlahGaji'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalPotonganBpjs'], 0) ?: '' }}</strong></td>
                        {{-- <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalPotonganHariTua'], 0) }}</strong></td> --}}
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalPotonganKreditKasbon'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"><strong>{{ number_format($totalEmployeesSalary['totalGeneral'], 0) ?: '' }}</strong></td>
                        <td class="text-center border border-zinc-300"></td>
                        <td class="text-center border border-zinc-300"></td>
                      </tr>
                      <tr></tr>
                      @endif
                  </tbody>
                  <script>
                    document.addEventListener('DOMContentLoaded', function () {
                      // attach listeners to every data-employee row
                      document.querySelectorAll('tr[data-employee]').forEach(tr => {
                        tr.addEventListener('mouseenter', () => {
                          const id = tr.getAttribute('data-employee');
                          document.querySelectorAll('tr[data-employee="'+id+'"]').forEach(r => {
                            r.classList.add('bg-zinc-200/50'); // Tailwind class works if Tailwind CSS is loaded
                          });
                        });
                        tr.addEventListener('mouseleave', () => {
                          const id = tr.getAttribute('data-employee');
                          document.querySelectorAll('tr[data-employee="'+id+'"]').forEach(r => {
                            r.classList.remove('bg-zinc-200/50');
                          });
                        });
                      });
                    });
                  </script>

              </table>
              <!-- Tailwind-styled pagination -->
              <div class="mt-4 flex justify-center">
                  {{ $employees->links() }}
              </div>
          </div>
      </div>
  </div>
@endsection
