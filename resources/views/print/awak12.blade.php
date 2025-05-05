<!-- resources/views/user/print.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print User Details</title>
    <style>
        .link-button{
            display: inline-block;
            margin-top: 16px;
            margin-bottom: 16px;
            background-color: #374151;
            border-radius: 10px;
            padding-inline: 16px;
            padding-block: 10px;
            text-decoration: none;
            color:#eaeaea;
            border:none;
            outline: none;
        }

        .print-button{
            display: inline-block;
            margin-top: 16px;
            margin-bottom: 16px;
            border-radius: 10px;
            padding-inline: 16px;
            padding-block: 10px;
            text-decoration: none;
            color:#eaeaea;
            cursor: pointer;
            background-color: #2563eb;
            border:none;
            outline: none;
        }
        .print-button:hover{
            background-color: #1d4ed8;

        }
        .link-hover:hover{
            background-color: #1f2937;
        }
      /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }
        .ttd{
            width:80px;
            height: 35px;
        }
        .header-text{
            font-size: 2rem;
            text-align: center;
            line-height: 10px;
        }
        .header-subtext {
            font-size: 1.5rem;
            text-align:center;
            line-height: 14px;
        }
        .empty-list{
          color:red;
          background-color:#f3f4f6;
          border-radius:10px;
          padding-inline: 10px;
          padding-block: 8px;
        }
        .select-input{
          padding-block:10px;
          padding-inline: 16px;
          cursor: pointer;
        }
        form{
          margin-bottom: 10px;
        }
        table{
            font-size: 0.8rem;
        }
        th,td{
            border-color:black;
        }
        .h-ttd{
            width: 50px;
        }

        /* Hide the print button during printing */
        @media print {
            .print-button,.link-button {
                display: none;
            }

            body {
                margin: 0;
                padding: 0;
            }

            table {
                width: 100%;
                page-break-after: always;
            }
            th {
                background-color: #f4f4f4;
                border-color:black;
                font-size: 10px;
            }
            td{
                border-color:black;
                font-size: 10px;
            }
            body {
                font-size: 12pt;
                margin: 0;
            }
            .ttd{
                width:50px;
                object-fit: contain;
            }
            .header-text{
                font-size: 2rem;
                text-align: center;
                line-height: 10px;
            }
            .header-subtext {
                font-size: 1.5rem;
                text-align:center;
                line-height: 14px;
            }
            .empty-list{
              display:none;
            }
            form{
              display:none;
            }
            .h-name{
                width:150px;
            }
            .h-lahir{
                width:100px;
            }
            .h-t-diangkat{
                width:100px;
            }
            .h-tunjangan{
                width:100px;
            }
            .h-potongan{
                width:100px;
            }
            .h-gaji-pokok{
                width: 100px;
            }
            .h-jumlah{
                width: 100px;
            }
            .h-ttd{
                width: 50px;
            }

        }
    </style>
</head>
<body>
    <div class="px-4">
      <div>
          <h1 class="header-text text-2xl font-bold text-center">PT.GUNUNG SELATAN</h3>
          <h1 class="header-subtext text-xl font-bold text-center">GAJI KARYAWAN TRANSPORTIR AWAK 1 DAN AWAK 2</h3>
          {{-- <h1 class="header-subtext text-xl font-bold text-center">BULAN : {{ $month ?? '' }} {{ $year ?? '' }}</h3> --}}
          <h1 class="header-subtext text-xl font-bold text-center">BULAN : April 2025</h3>
      </div>


      <div class="w-full flex gap-4">
          <a href="{{ route('awak12.index') }}" class="link-button inline-block my-4 px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800"><- Kembali</a>
          <button class="print-button inline-block my-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" onclick="window.print()">🖨️ Print</button>
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
          <a href="{{ route('print.awak12.filtered') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Reset</a>
        @endif
      </form>

      <div class="bg-gray-100">
        @if($users->filter(fn($user) => $user->salary)->isNotEmpty())
            <!-- your table -->
        @else
            <p class="text-red-500 mt-4 empty-list">Tidak ada data gaji untuk bulan dan tahun yang dipilih.</p>
        @endif
        <table class="min-w-full table-auto border-collapse">
          <thead>
            <tr>
              <th rowspan="2" class="py-2 w-5 border border-black bg-gray-500">No.</th>
              <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[180px]">Nama</th>
              <!-- Gaji Pokok with 3 sub-columns -->
              <th rowspan="2" class="py-2 border border-black bg-gray-500 text-center">Gaji Pokok</th>
              <!-- hari kerja -->
              <th rowspan="2" class="py-2 border border-black bg-gray-500 text-center">Hari Kerja</th>
              <!-- jumlah retase -->
              <th colspan="2" class="py-2 border border-black bg-gray-500 text-center h-retase">Jumlah Retase</th>
              <!-- tarif retase -->
              <th rowspan="2" class="py-2 border border-black bg-gray-500 text-center">Tarif Retase</th>
              <!-- Tunjangan -->
              <th class="py-2 border border-black bg-gray-500">Tunjangan</th>
              <!-- jumlah ur -->
              <th rowspan="2" class="py-2 border border-black bg-gray-500">Jumlah UR</th>
              <!-- Jumlah Kotor -->
              <th rowspan="2" class="py-2 border border-black bg-gray-500 h-jumlah">Jumlah Gaji</th>
              <!-- Potongan with 3 sub-columns -->
              <th colspan="3" class="py-2 border border-black bg-gray-500 text-center">Potongan</th>
              <!-- Jumlah Bersih -->
              <th rowspan="2" class="py-2 border border-black bg-gray-500 h-jumlah">Jumlah Bersih</th>
              <!-- TTD -->
              <th rowspan="2" class="py-2 border border-black bg-gray-500 w-[50px] h-ttd">TTD</th>
            </tr>
            <tr>
              <!-- Sub-columns jumlah retase -->
              <th class="py-2 border border-black bg-gray-500 w-[120px]"></th>
              <th class="py-2 border border-black bg-gray-500 w-[120px]"></th>
              <!-- Sub-columns for tunjangan -->
              <th class="py-2 border border-black bg-gray-500 w-[120px] h-tunjangan">Makan</th>
              <!-- Sub-columns for Potongan -->
              <th class="py-2 border border-black bg-gray-500 w-[120px] h-potongan">BPJS</th>
              <th class="py-2 border border-black bg-gray-500 w-[120px] h-potongan">Tabungan hari tua</th>
              <th class="py-2 border border-black bg-gray-500 h-potongan">Kredit/kasbon</th>
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
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">{{ $no++ }}</td>
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">{{$user->nama}}</td>
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">Rp{{number_format($salary->gaji_pokok, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">{{$salary->hari_kerja}}</td>
                    @endif
                    <td class="text-center py-2 border border-gray-500">{{ $delivery->jumlah_retase }}</td>
                    <td class="text-center py-2 border border-gray-500">{{ $delivery->kota }}</td>
                    <td class="text-center py-2 border border-gray-500">Rp{{ number_format($delivery->tarif_retase, 0, ',', '.') }}</td>
                    @if($index === 0)
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">Rp{{number_format($salary->tunjangan_makan, 0, ',', '.')}}</td>
                      {{-- <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">Rp{{number_format($salary->tunjangan_hari_tua, 0, ',', '.')}}</td> --}}
                    @endif
                      <td class="text-center py-2 border border-gray-500">Rp{{number_format($delivery->jumlah_ur, 0, ',', '.')}}</td>
                    @if($index === 0)
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">Rp{{number_format($salary->jumlah_gaji, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">Rp{{number_format($salary->potongan_bpjs, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">Rp{{number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">Rp{{number_format($salary->potongan_kredit_kasbon, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">Rp{{number_format($salary->jumlah_bersih, 0, ',', '.')}}</td>
                      <td rowspan="{{ $deliveryCount }}" class="text-center py-2 border border-gray-500">
                          <img src="{{ file_exists(public_path('storage/ttd/' . $user->nama . '.png')) ? asset('storage/ttd/' . $user->nama . '.png') : '' }}" alt="ttd" class="w-20 h-20 object-contain">
                      </td>
                    @endif
                  </tr>
                  @endforeach
                @endif
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
</body>
</html>
