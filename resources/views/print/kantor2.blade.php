<!-- resources/views/employee/print.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/table.css')
    <title>Print Employee Details</title>
</head>
<body>
    <div class="px-4">
        {{-- <div>
            <h1 class="header-text text-2xl font-bold text-center">PT.GUNUNG SELATAN</h3>
            <h1 class="header-subtext text-xl font-bold text-center">DAFTAR :  GAJI KARYAWAN KANTOR 2</h3>
            <h1 class="header-subtext text-xl font-bold text-center">BULAN : {{ $month ?? '' }} {{ $year ?? '' }}</h3>
        </div> --}}
        <div class="logo-container">
          <img src="/image/gunsel.jpg" alt="logo gunsel" class="logo-gunsel">
        </div>
        <div class="kop-surat">
          <h1 class="header-text">PT.GUNUNG SELATAN</h3>
          <h1 class="header-subtext">KONTRAKTOR & LEVERANSIR</h1>
          <h1 class="header-subtext">NABIRE - PAPUA</h1>
          <h1 class="small-text">Alamat: Jln. R.E.Martadinata No.216, Telp: (0984) 21722, Bank: Mandiri & BPD</h1>
        </div>
        <div>
          <h1 class="subtext">DAFTAR :  GAJI KARYAWAN & KARYAWATI KANTOR 2</h1>
          <h1 class="subtext">BULAN : {{ $month ?? '' }} {{ $year ?? '' }}</h3>
        </div>

        <div>
            <a href="{{ route('filterbymonth.kantor',['bulan' => request('bulan'),'tahun' => request('tahun'),'kantor' => 'kantor 2']) }}" class="link-button"><- Kembali</a>
            <button class="print-button" onclick="window.print()">🖨️ Print</button>
        </div>

        <form method="GET" action="{{ route('print.kantor2.filtered') }}" class="mb-4">
          <select name="bulan" required class="select-input">
              <option value="">-- Pilih Bulan --</option>
              @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                  <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
              @endforeach
          </select>

          <select name="tahun" required class="select-input">
              <option value="">-- Pilih Tahun --</option>
              @for ($y = 2020; $y <= now()->year; $y++)
                  <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
              @endfor
          </select>

          <button type="submit" class="select-input btn-filter">Filter</button>
        </form>

        <div>
          @if($employees->filter(fn($employee) => $employee->salary)->isNotEmpty())
              <!-- your table -->
          @else
              <p class="empty-list">Tidak ada data gaji untuk bulan dan tahun yang dipilih.</p>
          @endif
          <table class="table-auto border-collapse">
            <thead>
              <tr>
                <th class="h-no">No.</th>
                <th class="h-name">Nama</th>
                {{-- <th class="py-2 border border-black bg-gray-500">Tempat, Tanggal Lahir</th>
                <th class="py-2 border border-black bg-gray-500">Tanggal diangkat</th> --}}

                <th>Masuk Kerja</th>
                <!-- Gaji Pokok with 3 sub-columns -->
                <th class="h-gaji-pokok">Gaji Pokok (Rp.)</th>
                <th class="h-hari-kerja">Hari Kerja</th>

                <!-- Tunjangan -->
                <!-- Sub-columns for tunjangan -->
                <th class="h-tunjangan">Uang Makan (Rp.)</th>

                <!-- Jumlah Kotor -->
                <th class="h-total-gaji">Total Gaji (Rp.)</th>

                <!-- Potongan with 3 sub-columns -->
                <!-- Sub-columns for Potongan -->
                <th class="h-potongan">Kredit/kasbon (Rp.)</th>
                <th class="h-potongan">BPJS (Rp.)</th>
                {{-- <th class="h-potongan">Tabungan hari tua</th> --}}

                <!-- Jumlah Bersih -->
                <th class="h-gaji-bersih">Jumlah Gaji Bersih (Rp.)</th>

                <!-- TTD -->
                <th class="h-ttd">TTD</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; $num = 1;@endphp
              @foreach($employees as $employee)
                @php
                  $salary = $employee->salary;
                @endphp
                @if ($employee->salary)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td class="td-nama">{{$employee->nama}}</td>
                    {{-- <td>{{$employee->tempat_lahir . ', ' . $employee->tanggal_lahir->format('d M Y') }}</td> --}}
                    <td class="h-masuk-kerja">{{$employee->tanggal_diangkat}}</td>

                    <td>{{number_format($salary->gaji_pokok, 0, ',', '.')}}</td>
                    
                    <td class="el-center">{{$salary->hari_kerja}}</td>
                    <td>{{number_format($salary->tunjangan_makan, 0, ',', '.') ?: ''}}</td>
                    {{-- <td>{{number_format($salary->tunjangan_hari_tua, 0, ',', '.')}}</td> --}}
                    <td>{{number_format($salary->jumlah_gaji, 0, ',', '.')}}</td>
                    <td>{{number_format($salary->potongan_kredit_kasbon, 0, ',', '.') ?: ''}}</td>
                    <td>{{number_format($salary->potongan_bpjs, 0, ',', '.') ?: ''}}</td>
                    {{-- <td>{{number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.')}}</td> --}}
                    <td>{{number_format($salary->jumlah_bersih, 0, ',', '.')}}</td>
                    
                    @if($num % 2 == 0)
                    <td class="el-center">
                      {{ $num++ }}.
                      {{-- <img src="{{ asset('storage/ttd/' . $employee->nama. '.png') }}" alt="{{ "ttd" . $employee->nama }}" class="ttd"> --}}
                    </td>
                    @else
                      <td class="el-left">{{ $num++ }}.</td>
                    @endif
                  </tr>
                @endif
              @endforeach
              <tr class="row-total">
                <td></td>
                <td colspan="2"><strong>TOTAL</strong></td>
                <td>{{number_format($totalEmployeesSalary['totalGajiPokok'], 0) ?: ''}}</td>
                <td></td>
                <td>{{number_format($totalEmployeesSalary['totalTunjanganMakan'], 0) ?: ''}}</td>
                {{-- <td>{{number_format($salary->tunjangan_hari_tua, 0, ',', '.')}}</td> --}}
                <td>{{number_format($totalEmployeesSalary['totalJumlahGaji'], 0) ?: ''}}</td>
                <td>{{number_format($totalEmployeesSalary['totalPotonganKreditKasbon'], 0) ?: ''}}</td>
                {{-- <td>{{number_format($totalEmployeesSalary['totalPotonganHariTua'], 0)}}</td> --}}
                <td>{{number_format($totalEmployeesSalary['totalPotonganBpjs'], 0) ?: ''}}</td>
                <td>{{number_format($totalEmployeesSalary['totalGeneral'], 0) ?: ''}}</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
</body>
</html>
