<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function create(){
        return view('user.create');
    }

    public function print()
    {
        $users = User::all();

        return view('user.print', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'kantor' => 'required|max:255',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'tanggal_diangkat' => 'required|date',
            'gaji_pokok' => 'required|numeric',
            'bulan' => 'required',
            'tahun' => 'required',
            'tunjangan_makan' => 'required|numeric',
            'tunjangan_hari_tua' => 'required|numeric',
            'tunjangan_retase' => 'required|numeric',
            'potongan_bpjs' => 'required|numeric',
            'potongan_tabungan_hari_tua' => 'required|numeric',
            'potongan_kredit_kasbon' => 'required|numeric',
            'ttd' => 'required|string',
        ]);

        // Clean the base64 signature
        $imageData = $request->input('ttd');
        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);

        // Create unique filename
        $fileName = $request->input('nama') . '.png';

        // Store file in storage/app/public/signatures
        Storage::disk('public')->put('ttd/' . $fileName, base64_decode($image));

        $user = new User();
        $salary = new Salary();

        $user->nama = $request->input('nama');
        $user->kantor = $request->input('kantor');
        $user->tempat_lahir = $request->input('tempat_lahir');
        $user->tanggal_lahir = $request->input('tanggal_lahir');
        $user->tanggal_diangkat = $request->input('tanggal_diangkat');

        $user->save();

        $salary->user_id = $user->id;
        $salary->gaji_pokok = $request->input('gaji_pokok');
        $salary->bulan = $request->input('bulan');
        $salary->tahun = $request->input('tahun');
        $salary->tunjangan_makan = $request->input('tunjangan_makan');
        $salary->tunjangan_hari_tua = $request->input('tunjangan_hari_tua');
        $salary->tunjangan_retase = $request->input('tunjangan_retase');
        $salary->potongan_bpjs = $request->input('potongan_bpjs');
        $salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua');
        $salary->potongan_kredit_kasbon = $request->input('potongan_kredit_kasbon');
        $salary->ttd = $fileName;

        $salary->save();
        $salary->refresh();

        return redirect()->route('daftar.index')->with('success', 'user saved successfully!');

    }
}
