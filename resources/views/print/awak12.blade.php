<!-- resources/views/user/print.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/table.css')
    <title>Print User Details</title>
</head>
<body>
    <div class="px-4">
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
        {{-- <h1 class="header-subtext">GAJI KARYAWAN TRANSPORTIR AWAK 1 DAN AWAK 2</h3> --}}
        <h1 class="subtext">DAFTAR :  GAJI KARYAWAN & KARYAWATI TRANSPORTIR AWAK 1 & AWAK 2</h1>
        <h1 class="subtext">BULAN : {{ $month ?? '' }} {{ $year ?? '' }}</h3>
      </div>


      <div>
          <a href="{{ route('awak12.index', ['bulan' => request('bulan'),'tahun' => request('tahun'),'kantor' => 'kantor 1']) }}" class="link-button"><- Kembali</a>
          <button class="print-button" onclick="window.print()">🖨️ Print</button>
      </div>

      <form method="GET" action="{{ route('print.awak12.filtered') }}">
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

        <button type="submit" class="select-input">Filter</button>

        {{-- Reset Filter Button --}}
        @if(request('bulan') || request('tahun'))
          <a href="{{ route('print.awak12.filtered') }}" class="select-input btn-reset">Reset</a>
        @endif
      </form>

      <div class="bg-gray-100">
        @if($users->filter(fn($user) => $user->salary)->isNotEmpty())
            <!-- your table -->
        @else
            <p class="empty-list">Tidak ada data gaji untuk bulan dan tahun yang dipilih.</p>
        @endif
        <table class="table-auto border-collapse">
          <thead>
            <tr>
              <th rowspan="2">No.</th>
              <th rowspan="2" class="h-name">Nama</th>
              <!-- Gaji Pokok with 3 sub-columns -->
              <th rowspan="2">Gaji Pokok</th>
              <!-- hari kerja -->
              <th rowspan="2">Hari Kerja</th>
              <!-- jumlah retase -->
              <th colspan="2" class="h-retase">Jumlah Retase</th>
              <!-- tarif retase -->
              <th rowspan="2">Tarif Retase</th>
              <!-- Tunjangan -->
              <th>Tunjangan</th>
              <!-- jumlah ur -->
              <th rowspan="2">Jumlah UR</th>
              <!-- Jumlah Kotor -->
              <th rowspan="2" class="h-jumlah">Jumlah Gaji</th>
              <!-- Potongan with 3 sub-columns -->
              <th colspan="3">Potongan</th>
              <!-- Jumlah Bersih -->
              <th rowspan="2" class="h-jumlah">Jumlah Bersih</th>
              <!-- TTD -->
              <th rowspan="2" class="h-ttd">TTD</th>
            </tr>
            <tr>
              <!-- Sub-columns jumlah retase -->
              <th></th>
              <th></th>
              <!-- Sub-columns for tunjangan -->
              <th class="h-tunjangan">Makan</th>
              <!-- Sub-columns for Potongan -->
              <th class="h-potongan">BPJS</th>
              <th class="h-potongan">Tabungan hari tua</th>
              <th class="h-potongan">Kredit/kasbon</th>
            </tr>
          </thead>
          <tbody>
            @php $no = 1; @endphp
              @foreach($users as $user)
                @if ($user->salary)
                  @php $deliveryCount = $salary =
                      $user->salary;
                      $deliveryCount = $salary->deliveries->count();
                  @endphp
                  @foreach ($salary->deliveries as $index => $delivery)
                  <tr>
                    @if($index === 0)
                      <td rowspan="{{ $deliveryCount }}">{{ $no++ }}</td>
                      <td rowspan="{{ $deliveryCount }}" class="user-name">{{$user->nama}}</td>
                      <td rowspan="{{ $deliveryCount }}">Rp{{number_format($salary->gaji_pokok, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}">{{$salary->hari_kerja}}</td>
                    @endif
                    <td>{{ $delivery->jumlah_retase }}</td>
                    <td>{{ $delivery->kota }}</td>
                    <td>Rp{{ number_format($delivery->tarif_retase, 0, ',', '.') }}</td>
                    @if($index === 0)
                      <td rowspan="{{ $deliveryCount }}">Rp{{number_format($salary->tunjangan_makan, 0, ',', '.')}}</td>
                      {{-- <td rowspan="{{ $deliveryCount }}">Rp{{number_format($salary->tunjangan_hari_tua, 0, ',', '.')}}</td> --}}
                    @endif
                      <td>Rp{{number_format($delivery->jumlah_ur, 0, ',', '.')}}</td>
                    @if($index === 0)
                      <td rowspan="{{ $deliveryCount }}">Rp{{number_format($salary->jumlah_gaji, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}">Rp{{number_format($salary->potongan_bpjs, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}">Rp{{number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}">Rp{{number_format($salary->potongan_kredit_kasbon, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}">Rp{{number_format($salary->jumlah_bersih, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}">
                          {{-- <img src="{{ file_exists(public_path('storage/ttd/' . $user->nama . '.png')) ? asset('storage/ttd/' . $user->nama . '.png') : '' }}" alt="ttd"> --}}
                      </td>
                    @endif
                  </tr>
                  @endforeach
                @endif
              @endforeach
              <tr class="row-total">
                <td></td>
                <td colspan="6"><strong>TOTAL</strong></td>
                <td><strong>Rp.{{number_format($totalUsersSalary['totalTunjanganMakan'], 0)}}</strong></td>
                {{-- <td>Rp.{{number_format($salary->tunjangan_hari_tua, 0, ',', '.')}}</td> --}}
                <td><strong>Rp.{{number_format($totalUsersSalary['totalJumlahRetase'], 0)}}</strong></td>
                <td><strong>Rp.{{number_format($totalUsersSalary['totalJumlahGaji'], 0)}}</strong></td>
                <td><strong>Rp.{{number_format($totalUsersSalary['totalPotonganBpjs'], 0)}}</strong></td>
                <td><strong>Rp.{{number_format($totalUsersSalary['totalPotonganHariTua'], 0)}}</strong></td>
                <td><strong>Rp.{{number_format($totalUsersSalary['totalPotonganKreditKasbon'], 0)}}</strong></td>
                <td><strong>Rp.{{number_format($totalUsersSalary['totalGeneral'], 0)}}</strong></td>
                <td></td>
              </tr>
          </tbody>
        </table>
      </div>
    </div>
</body>
</html>
