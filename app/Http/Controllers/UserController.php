<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function read()
    {
        $users = User::all();

        return view('table', compact('users'));
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

        User::create([
            'name' => $request->input('nama'),
            'tempat_tanggal_lahir'=> $request->input('tempat_tanggal_lahir'),
            'tanggal_diangkat' => $request->input('tanggal_diangkat'),
            'gaji_pokok' =>$request->input('gaji_pokok'),
            'tunjangan_makan'=>$request->input('tunjangan_makan'),
            'tunjangan_hari_tua' =>$request->input('tunjangan_hari_tua'),
            'tunjangan_retase'=>$request->input('tunjangan_retase'),
            'jumlah_kotor'=> $request->gaji_pokok + $request->tunjangan_makan + $request->tunjangan_retase + $request->tunjangan_hari_tua,
            'potongan_BPJS'=> $request->input('potongan_bpjs'),
            'potongan_tabungan_hari_tua'=>$request->input('potongan_tabungan_hari_tua'),
            'potongan_kredit_kasbon'=>$request->input('potongan_kredit_kasbon'),
            'jumlah_bersih'=>$request->jumlah_kotor - $request->potongan_BPJS - $request->potongan_tabungan_hari_tua - $request->potongan_kredit_kasbon,
            'ttd'=>$request->input('ttd')
        ]);
        // $user = new User();

        // $user->nama = $request->input('nama');
        // $user->tempat_tanggal_lahir = $request->input('tempat_tanggal_lahir');
        // $user->tanggal_diangkat = $request->input('tanggal_diangkat');
        // $user->gaji_pokok = $request->input('gaji_pokok'); 
        // $user->tunjangan_makan = $request->input('tunjangan_makan'); 
        // $user->tunjangan_hari_tua = $request->input('tunjangan_hari_tua'); 
        // $user->tunjangan_retase = $request->input('tunjangan_retase'); 
        // // $user->jumlah_kotor = $request->input('jumlah_kotor'); 
        // $user->potongan_BPJS = $request->input('potongan_bpjs'); 
        // $user->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua'); 
        // $user->potongan_kredit_kasbon = $request->input('potongan_kredit_kasbon'); 
        // // $user->jumlah_bersih = $request->input('jumlah_bersih'); 
        // $user->ttd = $request->input('ttd'); 
        
        // $user->save();

        return redirect('/')->with('success', 'user saved successfully!');
    }
}
