<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function read()
    {
        $users = User::all();

        return response()->json(['data' => $users], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'tempat_tanggal_lahir' => 'required',
            'tanggal_diangkat' => 'required|date',
            'gaji_pokok' => 'required',
            'jumlah_kotor' => 'required',
            'jumlah_bersih' => 'required',
        ]);

        $user = new User();

        $user->nama = $request->input('nama');
        $user->tempat_tanggal_lahir = $request->input('tempat_tanggal_lahir');
        $user->tanggal_diangkat = $request->input('tanggal_diangkat');
        $user->gaji_pokok = $request->input('gaji_pokok'); 
        $user->tunjangan_makan = $request->input('tunjangan_makan'); 
        $user->tunjangan_hari_tua = $request->input('tunjangan_hari_tua'); 
        $user->tunjangan_retar = $request->input('tunjangan_retar'); 
        $user->jumlah_kotor = $request->input('jumlah_kotor'); 
        $user->potongan_BPJS = $request->input('potongan_BPJS'); 
        $user->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua'); 
        $user->potongan_kredit_kasbon = $request->input('potongan_kredit_kasbon'); 
        $user->jumlah_bersih = $request->input('jumlah_bersih'); 
        $user->ttd = $request->input('ttd'); 
        
        $user->save();

        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }
}
