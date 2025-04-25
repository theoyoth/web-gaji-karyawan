<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function create(){
        return view('user.create');
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
            'tahun' => 'required|digits:4|integer|min:2010|max:'. date('Y'),
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
        $fileName = Str::title($request->input('nama')) . '.png';

        // Store file in storage/app/public/signatures
        Storage::disk('public')->put('ttd/' . $fileName, base64_decode($image));

        $user = new User();
        $salary = new Salary();

        $user->nama = Str::title($request->input('nama'));
        $user->kantor = $request->input('kantor');
        $user->tempat_lahir = Str::title($request->input('tempat_lahir'));
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

        if($user->kantor === 'kantor 1'){
            return redirect()->route('kantor1.index')->with('success', 'user saved successfully!');
        }
        else if($user->kantor === 'kantor 2'){
            return redirect()->route('kantor2.index')->with('success', 'user saved successfully!');
        }
        else if($user->kantor === 'awak 1 dan awak 2'){
            return redirect()->route('awak12.index')->with('success', 'user saved successfully!');
        }
        else{
            return redirect()->route('header.index')->with('success', 'user saved successfully!');
        }

    }

    public function destroy($id){
        $user = User::with('salaries')->findOrFail($id);

        // Loop through each salary associated with the user
        foreach ($user->salaries as $salary) {
            $fileName = Str::title($user->nama) . '.png'; // using capital first letter user's name for the signature
            $path = 'ttd/' . $fileName;

            if (Storage::disk('public')->exists($path)) {
                // Delete the file
                Storage::disk('public')->delete($path);
            }

            // Optionally delete the salary record if needed
            $salary->delete();
        }

        // Delete the user
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
