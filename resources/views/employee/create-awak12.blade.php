@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
  <div class="bg-zinc-100 rounded-md h-[50px] flex items-center justify-between px-1">
    <a href="{{ route('awak12.index', ['bulan' => request('bulan'),'tahun' => request('tahun'),'page' => 1]) }}" class="max-w-max flex items-center bg-zinc-800 text-white rounded-md hover:bg-zinc-900 px-4 py-1"><i class="fas fa-arrow-left text-sm mr-2 text-zinc-100"></i>kembali</a>
  </div>
  <main class="flex justify-center items-center h-[90vh]">
    <div class="w-11/12 py-2 px-10 bg-zinc-100 rounded-lg border-2 border-white">
      <h1 class="text-2xl font-bold text-center">INPUT RETASE TRANSPORTIR</h1>
      <h1 class="text-2xl font-bold text-center">AWAK 1 & AWAK 2</h1>
      <div class="mt-8">
        @if(session('error'))
          <div id="error-msg" class="bg-red-100 text-red-700 p-2 text-sm rounded my-2">
            {{ session('error') }}
          </div>
          <script>
            setTimeout(() => {
                const msg = document.getElementById('error-msg');
                if (msg) msg.style.display = 'none';
            }, 4000);
          </script>
        @endif
        <form action="{{ route('employee.storeAwak12') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="space-y-2">
              <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <select name="employee_id" id="employee_id" required class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    @foreach ($employees as $employee)
                      <option value="{{ $employee->id }}">{{ $employee->nama }}</option>
                    @endforeach
                </select>
                {{-- Checkbox --}}
                <label class="block mt-2">
                    <input type="checkbox" id="new_employee_checkbox" name="new_employee_checkbox" value="1">
                    Belum terdaftar
                </label>

                {{-- New employee Input (Hidden by Default) --}}
                <input type="text" id="nama" name="nama" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md" style="display: none;">

                @error('nama')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="kantor" class="block text-sm font-medium text-gray-700">Kantor</label>
                <input type="text" id="kantor" name="kantor" value="awak 1 dan awak 2" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md" readonly>
                @error('kantor')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji pokok</label>
                <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                @error('gaji_pokok')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="tanggal_diangkat" class="block text-sm font-medium text-gray-700">Tanggal masuk</label>
                <input type="text" id="tanggal_diangkat" name="tanggal_diangkat" value="{{ old('tanggal_diangkat') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                @error('tanggal_diangkat')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="hari_kerja" class="block text-sm font-medium text-gray-700">Hari kerja</label>
                <input type="number" id="hari_kerja" name="hari_kerja" value="{{ old('hari_kerja') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                @error('hari_kerja')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                <select name="bulan" value="{{ old('bulan') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    <option value="Januari" {{ request('bulan') === 'Januari' ? 'selected' : '' }}>Januari</option>
                    <option value="Februari" {{ request('bulan') === 'Februari' ? 'selected' : '' }}>Februari</option>
                    <option value="Maret" {{ request('bulan') === 'Maret' ? 'selected' : '' }}>Maret</option>
                    <option value="April" {{ request('bulan') === 'April' ? 'selected' : '' }}>April</option>
                    <option value="Mei" {{ request('bulan') === 'Mei' ? 'selected' : '' }}>Mei</option>
                    <option value="Juni" {{ request('bulan') === 'Juni' ? 'selected' : '' }}>Juni</option>
                    <option value="Juli" {{ request('bulan') === 'Juli' ? 'selected' : '' }}>Juli</option>
                    <option value="Agustus" {{ request('bulan') === 'Agustus' ? 'selected' : '' }}>Agustus</option>
                    <option value="September" {{ request('bulan') === 'September' ? 'selected' : '' }}>September</option>
                    <option value="Oktober" {{ request('bulan') === 'Oktober' ? 'selected' : '' }}>Oktober</option>
                    <option value="November" {{ request('bulan') === 'November' ? 'selected' : '' }}>November</option>
                    <option value="Desember" {{ request('bulan') === 'Desember' ? 'selected' : '' }}>Desember</option>
                </select>
                @error('bulan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select name="tahun" id="tahun" required class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    @for ($y = 2020; $y <= now()->year; $y++)
                        <option value="{{ $y }}" {{ (request('tahun') ?? now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                @error('tahun')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <!-- middle Column -->
            <div class="space-y-2">
              <div class="flex items-center gap-10">
                <p class="block text-sm font-medium text-gray-700">Tunjangan</p>
                <div class="flex-1">
                  <div class="mt-2">
                      <label for="tunjangan_makan" class="block text-sm font-medium text-gray-700">Makan</label>
                      <input type="number" id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                      @error('tunjangan_makan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                      @enderror
                  </div>
                  {{-- <div class="mt-2">
                      <label for="tunjangan_hari_tua" class="block text-sm font-medium text-gray-700">Hari tua</label>
                      <input type="number" id="tunjangan_hari_tua" name="tunjangan_hari_tua" value="{{ old('tunjangan_hari_tua') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                      @error('tunjangan_hari_tua')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                      @enderror
                  </div> --}}
                </div>
              </div>
              <div class="flex items-center">
                  <p class="block text-sm font-medium text-gray-700 mr-10">Potongan</p>
                  <div class="flex-1">
                      <div class="mt-2">
                        <label for="potongan_bpjs" class="block text-sm font-medium text-gray-700">BPJS</label>
                        <input type="number" id="potongan_bpjs" name="potongan_bpjs" value="{{ old('potongan_bpjs') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                        @error('potongan_bpjs')
                          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                      </div>
                      {{-- <div class="mt-2">
                          <label for="potongan_tabungan_hari_tua" class="block text-sm font-medium text-gray-700">Tabungan hari tua</label>
                          <input type="number" id="potongan_tabungan_hari_tua" name="potongan_tabungan_hari_tua" value="{{ old('potongan_tabungan_hari_tua') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                          @error('potongan_tabungan_hari_tua')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                          @enderror
                      </div> --}}
                      <div class="mt-2">
                        <label for="potongan_kredit_kasbon" class="block text-sm font-medium text-gray-700">Kredit/Kasbon</label>
                        <input type="number" id="potongan_kredit_kasbon" name="potongan_kredit_kasbon" value="{{ old('potongan_kredit_kasbon') }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                        @error('potongan_kredit_kasbon')
                          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                      </div>
                  </div>
              </div>
              <div class="border border-zinc-200 p-2 rounded-md mt-4">
                {{-- Foto profil input --}}
                {{-- foto preview --}}
                <div class="relative">
                  <img id="preview" src="#" alt="Preview Foto" class="mt-2 w-32 h-40 object-cover rounded-md hidden">
                  {{-- Cross icon to remove photo --}}
                  <button type="button" id="removeBtn" onclick="removePhoto()" class="absolute top-0 left-0 bg-black text-white rounded-full w-6 h-6 items-center justify-center hidden">
                    &times;
                  </button>
                </div>
                {{-- input foto --}}
                <div id="uploadBox">
                  <label for="foto_profil" class="flex flex-col items-center justify-center gap-2 text-xl text-zinc-800 h-[100px] rounded-lg border border-dashed border-zinc-900 cursor-pointer hover:bg-zinc-200/50 transition">
                    <i class="fa fa-upload text-2xl text-zinc-700"></i>
                    <span>Upload Foto</span>
                  </label>
                  <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="mt-1 outline-1 h-10 px-2 py-1 rounded-md hidden">

                  @error('foto_profil')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>
                {{-- TTD --}}
                <div class="mt-4">
                  <label for="signature" class="block text-sm font-medium text-gray-700">Tanda tangan</label>
                  <canvas id="signature-pad" width="200" height="100" class="bg-white border border-zinc-200"></canvas>
                  <input type="hidden" name="ttd" id="ttd">
                  <p class="text-gray-500 text-xs mt-1">Gambar tanda tangan di atas</p>
                  <div class="flex mt-2">
                    <button type="button" id="clear" class="mr-4 bg-red-500 hover:bg-red-600 text-white px-6 py-1 rounded-md">Clear</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Right Column -->
            <div class="space-y-4">
              <div>
                <h2 class="text-lg font-bold mb-2">Input Retase</h2>
                <div id="delivery-wrapper">
                  <div class="flex flex-col gap-1 pb-2 border-b border-zinc-200">
                    <div>
                      <input type="text" name="deliveries[0][kota]" value="{{ $delivery['kota'] ?? '' }}" placeholder="kota" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    </div>
                    <div>
                      <input type="number" name="deliveries[0][jumlah_retase]" value="{{ $delivery['jumlah_retase'] ?? '' }}" placeholder="jumlah retase" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    </div>
                    <div>
                      <input type="number" name="deliveries[0][tarif_retase]" value="{{ $delivery['tarif_retase'] ?? '' }}" placeholder="tarif retase" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    </div>
                  </div>
                </div>
                <button type="button" onclick="addDeliveryRow()" class="text-white px-6 py-1 mt-2 bg-zinc-800 rounded-md hover:bg-zinc-900">+ Tambah Retase</button>
              </div>
            </div> 
          </div>  
          <div class="w-full mt-6">
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
                  if (!signaturePad.isEmpty()) {
                    document.getElementById('ttd').value = signaturePad.toDataURL();
                  } else {
                    document.getElementById('ttd').value = '';
                  }

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
                    row.className = 'delivery-row flex flex-col gap-1 pb-2 border-b border-zinc-200';
                    row.innerHTML = `
                        <input type="text" name="deliveries[${deliveryIndex}][kota]" placeholder="Kota" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                        <input type="number" name="deliveries[${deliveryIndex}][jumlah_retase]" placeholder="Jumlah retase" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                        <input type="number" name="deliveries[${deliveryIndex}][tarif_retase]" placeholder="Tarif retase" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">

                        <button type="button" onclick="removeDeliveryRow(this)" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded">Hapus</button>
                    `;
                    wrapper.appendChild(row);
                    deliveryIndex++;
                }

                function removeDeliveryRow(button) {
                    button.parentElement.remove();
                }

                // add shortcut to submit
                document.addEventListener('keydown', function (event) {
                  if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
                    event.preventDefault(); // prevent browser's default save dialog

                    const form = document.querySelector('form');
                    if (form) {
                      form.submit();
                    }
                  }
                  if (event.ctrlKey && event.shiftKey && event.key.toLowerCase() === 'a') {
                    event.preventDefault(); // prevent browser's default save dialog
                    addDeliveryRow();
                  }
                });

                // preview foto
                document.getElementById('foto_profil').addEventListener('change', function(event) {
                  const preview = document.getElementById('preview');
                  const removeBtn = document.getElementById('removeBtn');
                  const file = event.target.files[0];

                  // if (file) {
                  //     preview.src = URL.createObjectURL(file);
                  //     preview.classList.remove('hidden');
                  //     removeBtn.classList.remove('hidden');
                  // }
                  const reader = new FileReader();
                  reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    removeBtn.classList.remove('hidden');
                    uploadBox.classList.add('hidden'); // HIDE upload box
                  };
                  reader.readAsDataURL(file);
                });

                function removePhoto() {
                  document.getElementById('preview').src = "#";
                  document.getElementById('preview').classList.add('hidden');
                  document.getElementById('removeBtn').classList.add('hidden');
                  document.getElementById('uploadBox').classList.remove('hidden');
                  // also clear the input
                  document.getElementById('foto_profil').value = "";
                }

                const checkbox = document.getElementById('new_employee_checkbox');
                const namaInput = document.getElementById('nama');
                const employeeSelect = document.getElementById('employee_id');

                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        namaInput.style.display = 'block';
                        employeeSelect.disabled = true;
                        // employeeSelect.value = ""; 
                    } else {
                        namaInput.style.display = 'none';
                        employeeSelect.disabled = false;
                    }
                });
            </script>
    </div>
  </main>
@endsection
