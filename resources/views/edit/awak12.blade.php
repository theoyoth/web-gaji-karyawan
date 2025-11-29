@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
  <div class="bg-zinc-100 rounded-md h-[50px] flex items-center justify-between px-1">
    @php
      $bul = $employee->salary->bulan;
      $tah = $employee->salary->tahun;
    @endphp
    <a href="{{ route('awak12.index',['bulan' => $bul,'tahun' => $tah,'page' => request('page')]) }}" class="max-w-max flex items-center bg-zinc-800 text-white rounded-md hover:bg-zinc-900 px-4 py-1"><i class="fas fa-arrow-left text-sm mr-2 text-zinc-100"></i> kembali</a>
  </div>
  <main class="flex justify-center items-center mt-8">
    <div class="w-11/12 py-2 px-10 bg-zinc-100 rounded-lg border-2 border-white">
      <h1 class="text-3xl font-bold text-center">EDIT TRANSPORTIR AWAK 1, AWAK 2</h1>
      <div class="mt-8">
        <form action="{{ route('update.awak12', $employee->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="space-y-2">
              {{-- send hidden page pagination number to backend --}}
              <input type="hidden" name="page" value="{{ request('page') }}">
              <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama',$employee->nama) }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                @error('nama')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
              <div>
                <label for="kantor" class="block text-sm font-medium text-gray-700">Kantor</label>
                <select name="kantor" id="kantor" required class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    @foreach (['awak 1 dan awak 2'] as $kan)
                        <option value="{{ $kan }}" {{ request('kan') ? 'selected' : '' }}>{{ $kan }}</option>
                    @endforeach
                </select>
                @error('kantor')
                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
              </div>
              @if($employee->salary)
                <div>
                  <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji pokok</label>
                  <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok',$salary->gaji_pokok) }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                  @error('gaji_pokok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>
                <div>
                  <label for="hari_kerja" class="block text-sm font-medium text-gray-700">Hari kerja</label>
                  <input type="number" id="hari_kerja" name="hari_kerja" value="{{ old('hari_kerja',$salary->hari_kerja) }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                  @error('hari_kerja')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>
                <div>
                  <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                  <select name="bulan" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    <option value="Januari" {{ old('bulan', $salary->bulan) == 'Januari' ? 'selected' : '' }}>Januari</option>
                    <option value="Februari" {{ old('bulan', $salary->bulan) == 'Februari' ? 'selected' : '' }}>Februari</option>
                    <option value="Maret" {{ old('bulan', $salary->bulan) == 'Maret' ? 'selected' : '' }}>Maret</option>
                    <option value="April" {{ old('bulan', $salary->bulan) == 'April' ? 'selected' : '' }}>April</option>
                    <option value="Mei" {{ old('bulan', $salary->bulan) == 'Mei' ? 'selected' : '' }}>Mei</option>
                    <option value="Juni" {{ old('bulan', $salary->bulan) == 'Juni' ? 'selected' : '' }}>Juni</option>
                    <option value="Juli" {{ old('bulan', $salary->bulan) == 'Juli' ? 'selected' : '' }}>Juli</option>
                    <option value="Agustus" {{ old('bulan', $salary->bulan) == 'Agustus' ? 'selected' : '' }}>Agustus</option>
                    <option value="September" {{ old('bulan', $salary->bulan) == 'September' ? 'selected' : '' }}>September</option>
                    <option value="Oktober" {{ old('bulan', $salary->bulan) == 'Oktober' ? 'selected' : '' }}>Oktober</option>
                    <option value="November" {{ old('bulan', $salary->bulan) == 'November' ? 'selected' : '' }}>November</option>
                    <option value="Desember" {{ old('bulan', $salary->bulan) == 'Desember' ? 'selected' : '' }}>Desember</option>
                  </select>
                  @error('bulan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
                </div>
                <div>
                  <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                  <select name="tahun" id="tahun" required class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                      @for ($y = 2020; $y <= now()->year; $y++)
                          <option value="{{ $y }}" {{ $salary->tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
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
                    <input type="number" id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan',$salary->tunjangan_makan) }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
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
            </div>
            {{-- middle column --}}
            <div>
              
              <div class="flex items-center">
                <p class="block text-sm font-medium text-gray-700 mr-10">Potongan</p>
                <div class="flex-1">
                  <div class="mt-2">
                    <label for="potongan_bpjs" class="block text-sm font-medium text-gray-700">BPJS</label>
                    <input type="number" id="potongan_bpjs" name="potongan_bpjs" value="{{ old('potongan_bpjs',$salary->potongan_bpjs) }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    @error('potongan_bpjs')
                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="mt-2">
                    <label for="potongan_tabungan_hari_tua" class="block text-sm font-medium text-gray-700">Tabungan hari tua</label>
                    <input type="number" id="potongan_tabungan_hari_tua" name="potongan_tabungan_hari_tua" value="{{ old('potongan_tabungan_hari_tua',$salary->potongan_tabungan_hari_tua) }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    @error('potongan_tabungan_hari_tua')
                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="mt-2">
                    <label for="potongan_kredit_kasbon" class="block text-sm font-medium text-gray-700">Kredit/Kasbon</label>
                    <input type="number" id="potongan_kredit_kasbon" name="potongan_kredit_kasbon" value="{{ old('potongan_kredit_kasbon',$salary->potongan_kredit_kasbon) }}" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                    @error('potongan_kredit_kasbon')
                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="border border-zinc-200 p-2 rounded-md mt-4">
                {{-- Image container --}}
                <div>
                  <!-- Preview image -->
                  <div class="relative">
                    <img
                      id="preview"
                      src="{{ $employee->foto_profil ? asset('storage/' . $employee->foto_profil) : '#' }}"
                      alt="Preview Foto"
                      class="mt-2 w-32 h-36 object-cover rounded-md {{ $employee->foto_profil ? '' : 'hidden' }}">
                    {{-- Cross icon to remove photo --}}
                    <button type="button" id="removeBtn" onclick="removePhoto()" class="absolute top-0 left-0 bg-black text-white rounded-full w-6 h-6 items-center justify-center {{ $employee->foto_profil ? '' : 'hidden' }}">
                      &times;
                    </button>
                    {{-- Hidden input to signal removal --}}
                    <input type="hidden" name="hapus_foto" id="hapus_foto" value="0">
                  </div>
                  <!-- Upload new photo -->
                  <div id="uploadBox" class="{{ $employee->foto_profil ? 'hidden' : '' }}">
                    <label for="foto_profil" class="flex flex-col items-center justify-center gap-2 text-xl text-zinc-800 h-[100px] rounded-lg border border-dashed border-zinc-900 cursor-pointer hover:bg-zinc-200/50 transition">
                      <i class="fa fa-upload text-2xl text-zinc-700"></i>
                      <span>Upload Foto</span>
                    </label>
                    <input type="file" name="foto_profil" id="foto_profil" accept="image/*" class="mt-1 outline-1 h-10 px-2 py-1 rounded-md hidden">
                    @error('foto_profil')
                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                {{-- TTD --}}
                <input type="hidden" name="delete_ttd" id="delete_ttd" value="0">
                <div class="mt-4">
                  <label for="signature" class="block text-sm font-medium text-gray-700">Tanda tangan</label>
                  <canvas id="signature-pad" width="200" height="100" class="bg-white border border-zinc-200" data-image="{{ $salary->ttd ? asset('storage/ttd/' . $salary->ttd) : '' }}"></canvas>
                  <input type="hidden" name="ttd" id="ttd" value="{{ old('ttd', $salary->ttd ?? '') }}">
                  <p class="text-gray-500 text-xs mt-1">Gambar tanda tangan di atas</p>
                  <div class="flex mt-2">
                    <button type="button" id="clear" class="mr-4 bg-red-500 hover:bg-red-600 text-white px-6 py-1 rounded-md" disabled>Clear</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
              <div>
                <h2 class="text-lg font-bold mb-2">Input Retase</h2>
                <div id="delivery-wrapper">
                  @foreach ($salary->deliveries as $i => $delivery)
                    <div class="flex flex-col gap-1 pb-2 border-b border-zinc-200">
                      <div>
                        <input type="text" name="deliveries[{{ $i }}][kota]" value="{{ $delivery->kota ?? '' }}" placeholder="kota" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                      </div>
                      <div>
                        <input type="number" name="deliveries[{{ $i }}][jumlah_retase]" value="{{ $delivery->jumlah_retase ?? '' }}" placeholder="jumlah retase" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                      </div>
                      <div>
                        <input type="number" name="deliveries[{{ $i }}][tarif_retase]" value="{{ $delivery->tarif_retase ?? '' }}" placeholder="tarif retase" class="mt-1 outline-1 w-full h-10 px-2 py-1 border border-gray-200 rounded-md">
                      </div>
                      <button type="button" onclick="removeDeliveryRow(this)" class="bg-red-500 hover:bg-red-600 text-white px-4 py-0 rounded">Hapus</button>
                    </div>
                  @endforeach
                </div>
                <button type="button" onclick="addDeliveryRow()" class="text-white px-6 py-1 mt-2 bg-zinc-800 rounded-md hover:bg-zinc-900">+ Tambah Pengiriman</button>
              </div>
              
            </div>
            @endif
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
          const ttdInput = document.getElementById('ttd');
          const clearBtn = document.getElementById('clear');

          // Disable clear button by default
          function disableClearButton() {
            clearBtn.disabled = true;
            clearBtn.classList.add('opacity-50', 'cursor-not-allowed');
          }

          function enableClearButton() {
            clearBtn.disabled = false;
            clearBtn.classList.remove('opacity-50', 'cursor-not-allowed');
          }

          // Load existing signature if available
          const existingImage = canvas.dataset.image;
          if (existingImage) {
            const img = new Image();
            img.src = existingImage;
            img.onload = () => {
              const ctx = canvas.getContext('2d');
              ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            };
            enableClearButton();
          } else {
            disableClearButton();
          }

          // Watch employee drawing and enable clear
          signaturePad.onBegin = () => {
            if (signaturePad.isEmpty()) return;
            disableClearButton();
          };
            // Watch employee drawing and enable clear
          signaturePad.onEnd = () => {
            if (!signaturePad.isEmpty()) {
              enableClearButton();
            }
          };

          // Submit form: set ttd input to base64 image
          document.querySelector('form').addEventListener('submit', function () {
            if (!signaturePad.isEmpty()) {
              ttdInput.value = signaturePad.toDataURL('image/png');
            } else {
              ttdInput.value = '';
            }
          });

          // Clear signature and delete signature
          const deleteTtdInput = document.getElementById('delete_ttd');
          clearBtn.addEventListener('click', function () {
            signaturePad.clear();
            ttdInput.value = '';
            deleteTtdInput.value = '1';
            disableClearButton(); // Re-disable after clearing
          });

          // setting for multiple input retase
          let deliveryIndex = {{ count($salary->deliveries) }};

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

          document.getElementById('foto_profil').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            const removeBtn = document.getElementById('removeBtn');
            const file = event.target.files[0];

            const reader = new FileReader();
            reader.onload = function(e) {
              preview.src = e.target.result;
              preview.classList.remove('hidden');
              removeBtn.classList.remove('hidden');
              uploadBox.classList.add('hidden'); // HIDE upload box
            };
            reader.readAsDataURL(file);
          } )
  
          function removePhoto() {
            document.getElementById('hapus_foto').value = '1';
            document.getElementById('preview').classList.add('hidden');
            document.getElementById('removeBtn').classList.add('hidden');
            document.getElementById('uploadBox').classList.remove('hidden');
            
            // clear the image src
            document.getElementById('foto_profil').value = "";
          }
        </script>
    </div>
  </main>
</div>
@endsection
