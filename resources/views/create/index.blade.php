@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
    <main class="h-screen flex justify-center items-center">
        <div class="w-2/3 m-auto">
            <h1 class="text-4xl font-bold text-center">FORMULIR INPUT</h1>
            <div class="mt-8">
                <form action="{{ route('create.user') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="tempat_tanggal_lahir" class="block text-sm font-medium text-gray-700">Tempat & tanggal lahir</label>
                                <input type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" value="{{ old('tempat_tanggal_lahir') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="tanggal_diangkat" class="block text-sm font-medium text-gray-700">Tanggal diangkat</label>
                                <input type="date" id="tanggal_diangkat" name="tanggal_diangkat" value="{{ old('tanggal_diangkat') }}"  class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji pokok</label>
                                <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex items-center gap-10">
                                <p class="block text-sm font-medium text-gray-700">Tunjangan</p>
                                <div class="flex-1">
                                    <div class="mt-2">
                                        <label for="tunjangan_makan" class="block text-sm font-medium text-gray-700">Makan</label>
                                        <input type="number" id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="mt-2">
                                        <label for="tunjangan_hari_tua" class="block text-sm font-medium text-gray-700">Hari tua</label>
                                        <input type="number" id="tunjangan_hari_tua" name="tunjangan_hari_tua" value="{{ old('tunjangan_hari_tua') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="mt-2">
                                        <label for="tunjangan_retase" class="block text-sm font-medium text-gray-700">Retase</label>
                                        <input id="tunjangan_retase" name="tunjangan_retase" value="{{ old('tunjangan_retase') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <p class="block text-sm font-medium text-gray-700 mr-10">Potongan</p>
                                <div class="flex-1">
                                    <div class="mt-2">
                                        <label for="potongan_bpjs" class="block text-sm font-medium text-gray-700">BPJS</label>
                                        <input type="number" id="potongan_bpjs" name="potongan_bpjs" value="{{ old('potongan_bpjs') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="mt-2">
                                        <label for="potongan_tabungan_hari_tua" class="block text-sm font-medium text-gray-700">Tabungan hari tua</label>
                                        <input type="number" id="potongan_tabungan_hari_tua" name="potongan_tabungan_hari_tua" value="{{ old('potongan_tabungan_hari_tua') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="mt-2">
                                        <label for="potongan_kredit_kasbon" class="block text-sm font-medium text-gray-700">Kredit/Kasbon</label>
                                        <input type="number" id="potongan_kredit_kasbon" name="potongan_kredit_kasbon" value="{{ old('potongan_kredit_kasbon') }}" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>
                            </div>
                      
                            <div>
                                <label for="ttd" class="block text-sm font-medium text-gray-700">TTD</label>
                                <input type="checkbox" value="1" id="ttd" name="ttd" class="mt-1 outline-1 w-full h-10 px-2 rounded-md border-2 border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></input>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-40 bg-green-600 text-white font-semibold py-2 px-6 rounded hover:bg-green-700 focus:outline-none">
                            submit
                        </button>
                    </div>
                </form>
        </div>
    </main>
@endsection