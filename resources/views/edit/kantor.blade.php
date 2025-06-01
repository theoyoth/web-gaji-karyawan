@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
    <main class="min-h-screen flex justify-center items-center">
        <div class="w-1/2 m-auto py-2 px-10 bg-gray-100 rounded-lg border border-black my-4">
            @php
              $bul = $user->salary->bulan;
              $tah = $user->salary->tahun;
            @endphp
            <a href="{{ route('kantor1.index',['bulan' => $bul, 'tahun' => $tah, 'page' => request('page')]) }}" class="inline-block my-4 px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">
              <- kembali
            </a>
            <h1 class="text-3xl font-bold text-center">EDIT KANTOR 1 & KANTOR 2</h1>
            <div class="mt-8">
                <form action="{{ route('update.kantor', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      @php
                        $salary = $user->salary;
                      @endphp
                      @if($user->salary)
                      {{-- send hidden page pagination number to backend --}}
                      <input type="hidden" name="page" value="{{ request('page') }}">

                        <!-- Left Column -->
                        <div>
                          <div>
                              <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                              <input type="text" id="nama" name="nama" value="{{ old('nama',$user->nama) }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                              @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                          <div>
                              <label for="kantor" class="block text-sm font-medium text-gray-700">Kantor</label>
                              <select name="kantor" id="kantor" required class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                  @foreach (['kantor 1','kantor 2'] as $kan)
                                      <option value="{{ $kan }}" {{ $user->kantor == $kan ? 'selected' : '' }}>{{ $kan }}</option>
                                  @endforeach
                              </select>
                              @error('kantor')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                          <div>
                              <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji pokok</label>
                              <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok',$salary->gaji_pokok) }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                              @error('gaji_pokok')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                          <div>
                              <label for="hari_kerja" class="block text-sm font-medium text-gray-700">Hari kerja</label>
                              <input type="number" id="hari_kerja" name="hari_kerja" value="{{ old('hari_kerja',$salary->hari_kerja) }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                              @error('hari_kerja')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                          </div>
                          <div>
                              <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                              <select name="bulan" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500">
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
                              <select name="tahun" id="tahun" required class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
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
                                    <input type="number" id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan',$salary->tunjangan_makan) }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                    @error('tunjangan_makan')
                                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                {{-- <div class="mt-2">
                                    <label for="tunjangan_hari_tua" class="block text-sm font-medium text-gray-700">Hari tua</label>
                                    <input type="number" id="tunjangan_hari_tua" name="tunjangan_hari_tua" value="{{ old('tunjangan_hari_tua') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                    @error('tunjangan_hari_tua')
                                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                            </div>
                          </div>

                        </div>
                        {{-- right column --}}
                        {{-- TTD --}}
                        <div>
                          <div class="flex items-center">
                            <p class="block text-sm font-medium text-gray-700 mr-10">Potongan</p>
                            <div class="flex-1">
                              <div class="mt-2">
                                  <label for="potongan_bpjs" class="block text-sm font-medium text-gray-700">BPJS</label>
                                  <input type="number" id="potongan_bpjs" name="potongan_bpjs" value="{{ old('potongan_bpjs',$salary->potongan_bpjs) }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                  @error('potongan_bpjs')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                  @enderror
                              </div>
                              <div class="mt-2">
                                  <label for="potongan_tabungan_hari_tua" class="block text-sm font-medium text-gray-700">Tabungan hari tua</label>
                                  <input type="number" id="potongan_tabungan_hari_tua" name="potongan_tabungan_hari_tua" value="{{ old('potongan_tabungan_hari_tua',$salary->potongan_tabungan_hari_tua) }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                  @error('potongan_tabungan_hari_tua')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                  @enderror
                              </div>
                              <div class="mt-2">
                                <label for="potongan_kredit_kasbon" class="block text-sm font-medium text-gray-700">Kredit/Kasbon</label>
                                <input type="number" id="potongan_kredit_kasbon" name="potongan_kredit_kasbon" value="{{ old('potongan_kredit_kasbon',$salary->potongan_kredit_kasbon) }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm">
                                @error('potongan_kredit_kasbon')
                                  <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                              </div>
                            </div>
                          </div>
                          {{-- TTD --}}
                          <input type="hidden" name="delete_ttd" id="delete_ttd" value="0">
                          <div class="mt-4">
                              <label for="signature" class="block text-sm font-medium text-gray-700">Tanda tangan</label>
                              <canvas id="signature-pad" width="200" height="100" style="border: 1px solid #000;" data-image="{{ $salary->ttd ? asset('storage/ttd/' . $salary->ttd) : '' }}"></canvas>
                              <input type="hidden" name="ttd" id="ttd" value="{{ old('ttd', $salary->ttd ?? '') }}">
                              <p class="text-gray-500 text-xs mt-1">Gambar tanda tangan di atas</p>
                              <div class="flex mt-2">
                                <button type="button" disabled id="clear" class="mr-4 bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md">Clear</button>
                              </div>
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
                    }
                    enableClearButton();
                  } else {
                    disableClearButton();
                  }

                  // Watch user drawing and disable clear
                  signaturePad.onBegin = () => {
                    if (signaturePad.isEmpty()) return;
                    disabledClearButton();
                  };

                  // Watch user drawing and enable clear
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
                    disableClearButton();
                  });

                </script>
        </div>
    </main>
@endsection
