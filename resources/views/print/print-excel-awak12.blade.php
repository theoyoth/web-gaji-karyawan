<table class="table-auto border-collapse">
  <thead>
    <tr>
      <th rowspan="2">No.</th>
      <th rowspan="2">Nama</th>
      <th rowspan="2">Gaji Pokok</th>
      <th rowspan="2">Hari Kerja</th>
      <th colspan="2">Jumlah Retase</th>
      <th rowspan="2">Tarif Retase</th>
      <th>Tunjangan Makan</th>
      <th rowspan="2">Jumlah UR</th>
      <th rowspan="2">Jumlah Gaji</th>
      <th colspan="3">Potongan</th>
      <th rowspan="2">Jumlah Bersih</th>
      <th rowspan="2">TTD</th>
    </tr>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th>BPJS</th>
      <th>Tabungan Hari Tua</th>
      <th>Kredit/Kasbon</th>
    </tr>
  </thead>
  <tbody>
    @php $no = 1; @endphp
    @foreach($users as $user)
      @if ($user->salary)
        @php
          $salary = $user->salary;
          $deliveryCount = $salary->deliveries->count();
        @endphp
        @foreach ($salary->deliveries as $index => $delivery)
        <tr>
          @if($index === 0)
            <td rowspan="{{ $deliveryCount }}">{{ $no++ }}</td>
            <td rowspan="{{ $deliveryCount }}">{{ $user->nama }}</td>
            <td rowspan="{{ $deliveryCount }}">Rp{{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
            <td rowspan="{{ $deliveryCount }}">{{ $salary->hari_kerja }}</td>
          @endif

          <td>{{ $delivery->jumlah_retase }}</td>
          <td>{{ $delivery->kota }}</td>
          <td>Rp{{ number_format($delivery->tarif_retase, 0, ',', '.') }}</td>

          @if($index === 0)
            <td rowspan="{{ $deliveryCount }}">Rp{{ number_format($salary->tunjangan_makan, 0, ',', '.') }}</td>
          @endif

          <td>Rp{{ number_format($delivery->jumlah_ur, 0, ',', '.') }}</td>

          @if($index === 0)
            <td rowspan="{{ $deliveryCount }}">Rp{{ number_format($salary->jumlah_gaji, 0, ',', '.') }}</td>
            <td rowspan="{{ $deliveryCount }}">Rp{{ number_format($salary->potongan_bpjs, 0, ',', '.') }}</td>
            <td rowspan="{{ $deliveryCount }}">Rp{{ number_format($salary->potongan_tabungan_hari_tua, 0, ',', '.') }}</td>
            <td rowspan="{{ $deliveryCount }}">Rp{{ number_format($salary->potongan_kredit_kasbon, 0, ',', '.') }}</td>
            <td rowspan="{{ $deliveryCount }}">Rp{{ number_format($salary->jumlah_bersih, 0, ',', '.') }}</td>
            <td rowspan="{{ $deliveryCount }}">{{ $user->nama }}</td> {{-- Or use TTD if needed --}}
          @endif
        </tr>
        @endforeach
      @endif
    @endforeach

    <tr>
      <td></td>
      <td colspan="6"><strong>TOTAL</strong></td>
      <td><strong>Rp{{ number_format($totalUsersSalary['totalTunjanganMakan'], 0, ',', '.') }}</strong></td>
      <td><strong>Rp{{ number_format($totalUsersSalary['totalJumlahRetase'], 0, ',', '.') }}</strong></td>
      <td><strong>Rp{{ number_format($totalUsersSalary['totalJumlahGaji'], 0, ',', '.') }}</strong></td>
      <td><strong>Rp{{ number_format($totalUsersSalary['totalPotonganBpjs'], 0, ',', '.') }}</strong></td>
      <td><strong>Rp{{ number_format($totalUsersSalary['totalPotonganHariTua'], 0, ',', '.') }}</strong></td>
      <td><strong>Rp{{ number_format($totalUsersSalary['totalPotonganKreditKasbon'], 0, ',', '.') }}</strong></td>
      <td><strong>Rp{{ number_format($totalUsersSalary['totalGeneral'], 0, ',', '.') }}</strong></td>
      <td></td>
    </tr>
  </tbody>
</table>
