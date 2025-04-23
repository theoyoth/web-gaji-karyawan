@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
    <main class="w-3/4 border m-auto">
        <h1 class="text-4xl font-bold text-center">FORMULIR INPUT</h1>
        <div class="mt-8">
            <form action="" method="POST">
                @csrf
    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" id="nama" name="nama" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
    
                        <div>
                            <label for="tempat_tanggal_lahir" class="block text-sm font-medium text-gray-700">Tempat & tanggal lahir</label>
                            <input type="number" step="0.01" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="tahun_diangkat" class="block text-sm font-medium text-gray-700">Tahun diangkat</label>
                            <input type="number" step="0.01" id="tahun_diangkat" name="tahun_diangkat" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji pokok</label>
                            <input type="number" step="0.01" id="gaji_pokok" name="gaji_pokok" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="flex items-center">
                            <p class="block text-sm font-medium text-gray-700 mr-10">Tunjangan</p>
                            <div class="flex-1">
                                <div>
                                    <label for="makan" class="block text-sm font-medium text-gray-700">Makan</label>
                                    <input type="number" step="0.01" id="makan" name="makan" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="hari_tua" class="block text-sm font-medium text-gray-700">Hari tua</label>
                                    <input type="number" step="0.01" id="hari_tua" name="hari_tua" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="retase" class="block text-sm font-medium text-gray-700">Retase</label>
                                    <input step="0.01" id="retase" name="retase" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah kotor</label>
                            <input type="number" id="quantity" name="quantity" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
    
                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <p class="block text-sm font-medium text-gray-700 mr-10">Potongan</p>
                            <div class="flex-1">
                                <div>
                                    <label for="potongan_bpjs" class="block text-sm font-medium text-gray-700">BPJS</label>
                                    <input type="number" step="0.01" id="potongan_bpjs" name="potongan_bpjs" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="potongan_tabungan_hari_tua" class="block text-sm font-medium text-gray-700">Tabungan hari tua</label>
                                    <input type="number" step="0.01" id="potongan_tabungan_hari_tua" name="potongan_tabungan_hari_tua" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="potongan_kredit_kasbon" class="block text-sm font-medium text-gray-700">Kredit/Kasbon</label>
                                    <input step="0.01" id="potongan_kredit_kasbon" name="potongan_kredit_kasbon" required class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="jumlah_bersih" class="block text-sm font-medium text-gray-700">Jumlah bersih</label>
                            <input id="jumlah_bersih" name="jumlah_bersih" class="mt-1 outline-1 w-full h-8 px-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>
                </div>
    
                <div class="mt-6">
                    <button type="submit" class="w-40 bg-green-600 text-white font-semibold py-2 px-6 rounded hover:bg-green-700 focus:outline-none">
                        submit
                    </button>
                </div>
            </form>
    </main>
@endsection