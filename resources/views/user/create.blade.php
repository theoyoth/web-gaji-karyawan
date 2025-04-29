@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
    <main class="min-h-screen flex justify-center items-center">
        <div class="w-1/2 m-auto py-2 bg-gray-100 rounded-lg p-10 border border-black">
            <a href="{{ route('header.index') }}" class="inline-block my-4 px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">
              <- kembali
            </a>
            <h1 class="text-4xl font-bold text-center">FORMULIR INPUT</h1>
            <div class="mt-8">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                @error('nama')
                                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="kantor" class="block text-sm font-medium text-gray-700">Kantor</label>
                                {{-- <input type="text" id="kantor" name="kantor" value="{{ old('kantor') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm"> --}}

                                <select name="kantor" id="kantor" required class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                    @foreach (['awak 1 dan awak 2','kantor 1','kantor 2'] as $kan)
                                        <option value="{{ $kan }}" {{ request('kan') ? 'selected' : '' }}>{{ $kan }}</option>
                                    @endforeach
                                </select>
                                @error('kantor')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                            </div>
                            {{-- <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat lahir</label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                @error('tempat_lahir')
                                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                @error('tanggal_lahir')
                                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="tanggal_diangkat" class="block text-sm font-medium text-gray-700">Tanggal diangkat</label>
                                <input type="date" id="tanggal_diangkat" name="tanggal_diangkat" value="{{ old('tanggal_diangkat') }}"  class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                @error('tanggal_diangkat')
                                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div>
                                <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji pokok</label>
                                <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                @error('gaji_pokok')
                                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="hari_kerja" class="block text-sm font-medium text-gray-700">Hari kerja</label>
                                <input type="number" id="hari_kerja" name="hari_kerja" value="{{ old('hari_kerja') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                @error('hari_kerja')
                                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                                <select name="bulan" value="{{ old('bulan') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500">
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                </select>
                                @error('bulan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                                {{-- <input type="number" id="tahun" name="tahun" value="{{ old('tahun') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm" > --}}
                                <select name="tahun" id="tahun" required class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                    @for ($y = 2020; $y <= now()->year; $y++)
                                        <option value="{{ $y }}" {{ (request('tahun') ?? now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('tahun')
                                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center gap-10">
                              <p class="block text-sm font-medium text-gray-700">Tunjangan</p>
                              <div class="flex-1">
                                  <div class="mt-2">
                                      <label for="tunjangan_makan" class="block text-sm font-medium text-gray-700">Makan</label>
                                      <input type="number" id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                      @error('tunjangan_makan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="mt-2">
                                      <label for="tunjangan_hari_tua" class="block text-sm font-medium text-gray-700">Hari tua</label>
                                      <input type="number" id="tunjangan_hari_tua" name="tunjangan_hari_tua" value="{{ old('tunjangan_hari_tua') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                      @error('tunjangan_hari_tua')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                      @enderror
                                  </div>
                              </div>
                            </div>
                            <div class="flex items-center">
                              <p class="block text-sm font-medium text-gray-700 mr-10">Potongan</p>
                              <div class="flex-1">
                                  <div class="mt-2">
                                      <label for="potongan_bpjs" class="block text-sm font-medium text-gray-700">BPJS</label>
                                      <input type="number" id="potongan_bpjs" name="potongan_bpjs" value="{{ old('potongan_bpjs') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                      @error('potongan_bpjs')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="mt-2">
                                      <label for="potongan_tabungan_hari_tua" class="block text-sm font-medium text-gray-700">Tabungan hari tua</label>
                                      <input type="number" id="potongan_tabungan_hari_tua" name="potongan_tabungan_hari_tua" value="{{ old('potongan_tabungan_hari_tua') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                      @error('potongan_tabungan_hari_tua')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="mt-2">
                                      <label for="potongan_kredit_kasbon" class="block text-sm font-medium text-gray-700">Kredit/Kasbon</label>
                                      <input type="number" id="potongan_kredit_kasbon" name="potongan_kredit_kasbon" value="{{ old('potongan_kredit_kasbon') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                      @error('potongan_kredit_kasbon')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                      @enderror
                                  </div>
                              </div>
                          </div>

                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                              <label for="jumlah_gaji" class="block text-sm font-medium text-gray-700">Jumlah gaji</label>
                              <input type="number" id="jumlah_gaji" name="jumlah_gaji" value="{{ old('jumlah_gaji') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                              @error('jumlah_gaji')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                            </div>
                            <div class="">
                              <h2 class="text-lg font-bold mb-2">Input Retase</h2>
                              <div id="delivery-wrapper">
                                  <div class="flex flex-col gap-1 pb-2 border-b border-gray-500">
                                      <div>
                                        <input type="text" name="deliveries[0][kota]" placeholder="kota" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                      </div>
                                      <div>
                                        <input type="number" name="deliveries[0][jumlah_retase]" placeholder="jumlah retase" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                      </div>
                                      <div>
                                        <input type="number" name="deliveries[0][tarif_retase]" placeholder="tarif retase" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                      </div>
                                  </div>
                              </div>
                              <button type="button" onclick="addDeliveryRow()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded mt-4">+ Tambah Pengiriman</button>
                            </div>

                            {{-- TTD --}}
                            <div class="mt-4">
                                <label for="signature" class="block text-sm font-medium text-gray-700">Tanda tangan</label>
                                <canvas id="signature-pad" width="200" height="100" style="border: 1px solid #000;"></canvas>
                                <input type="hidden" name="ttd" id="signature">
                                <p class="text-gray-500 text-xs mt-1">Gambar tanda tangan di atas</p>
                                <div class="flex mt-2">
                                    <button type="button" id="clear" class="mr-4 bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full my-6">
                        <button type="submit" value="submit_data" class="w-full bg-green-600 text-white font-semibold py-2 px-6 rounded hover:bg-green-700 focus:outline-none">
                            submit
                        </button>
                    </div>
                </form>
                <!-- Include Signature Pad JS -->
                <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

                <script>
                  // input signature
                    const canvas = document.getElementById('signature-pad');
                    const signaturePad = new SignaturePad(canvas);

                    document.querySelector('form').addEventListener('submit', function (e) {
                        /*if (signaturePad.isEmpty()) {
                            alert("Silakan tanda tangan terlebih dahulu.");
                            e.preventDefault();
                            return;
                        }*/

                        // Convert to Base64 and set in hidden input
                        document.getElementById('signature').value = signaturePad.toDataURL();
                    });

                    // Clear the signature pad
                    document.getElementById('clear').addEventListener('click', function () {
                        signaturePad.clear();
                    });

                    // setting for multiple input retase
                    let deliveryIndex = 1;

                    function addDeliveryRow() {
                        const wrapper = document.getElementById('delivery-wrapper');
                        const row = document.createElement('div');
                        row.className = 'delivery-row flex flex-col gap-1 pb-2 border-b border-gray-500';
                        row.innerHTML = `
                            <input type="text" name="deliveries[${deliveryIndex}][kota]" placeholder="Kota" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                            <input type="number" name="deliveries[${deliveryIndex}][jumlah_retase]" placeholder="Jumlah retase" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                            <input type="number" name="deliveries[${deliveryIndex}][tarif_retase]" placeholder="Tarif retase" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">

                            <button type="button" onclick="removeDeliveryRow(this)" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
                        `;
                        wrapper.appendChild(row);
                        deliveryIndex++;
                    }

                    function removeDeliveryRow(button) {
                        button.parentElement.remove();
                    }
                </script>
        </div>
    </main>
@endsection
