<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class placeController extends Controller
{

    public function kantor1(Request $request){

        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "kantor 1")
                    ->with('salary')
                    ->paginate(15);

        return view('place.kantor1', compact('users'));
    }

    public function kantor2(){
        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "kantor 2")
                    ->with('salary')
                    ->paginate(15);

        return view('place.kantor2', compact('users'));
    }
    public function awak12(Request $request){
        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "awak 1 dan awak 2")
                    ->with('salary.deliveries')
                    ->paginate(15);
        
        // Initialize variables for total sums
        $totalJumlahBersih = 0;
        $totalTunjanganMakan = 0;
        $totalUpahRetase = 0;
        $totalPotonganBPJS = 0;
        $totalGeneral = 0;

        // Loop through users to calculate totals for the current page
        foreach ($users as $user) {
            $salary = $user->salary;
            $upahRetase = $salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase);

            // Calculate the totals for each field
            $jumlahBersih = $salary->jumlah_gaji - $salary->potongan_bpjs; // Customize this formula if needed
            $tunjanganMakan = $salary->tunjangan_makan;
            $potonganBPJS = $salary->potongan_bpjs;

            // Add to the running totals
            $totalJumlahBersih += $jumlahBersih;
            $totalTunjanganMakan += $tunjanganMakan;
            $totalUpahRetase += $upahRetase;
            $totalPotonganBPJS += $potonganBPJS;
            $totalGeneral += $jumlahBersih + $tunjanganMakan + $upahRetase - $potonganBPJS;
        }

        // return view('place.awak12', compact('users'));
        return view('place.awak12', compact('users', 'totalJumlahBersih', 'totalTunjanganMakan', 'totalUpahRetase', 'totalPotonganBPJS', 'totalGeneral'));
    }


    // FILTER controller
    public function filterKantor1(Request $request){
        $month = $request->input('bulan');
        $year = $request->input('tahun');
        $kantor = 'kantor 1';

        $users = User::where('kantor', $kantor) // Filter by kantor (from users table)
        ->whereHas('salary', function ($query) use ($month, $year) {
            // Filter salaries by bulan (month) and tahun (year)
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        })
        ->with(['salary' => function ($query) use ($month, $year) {
            // Also filter the eager-loaded salaries by bulan and tahun
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        }])
        ->get();

        return view('place.kantor1', compact('users', 'month', 'year'));
    }

    public function filterKantor2(Request $request){
        $month = $request->input('bulan');
        $year = $request->input('tahun');
        $kantor = 'kantor 2';

        $users = User::where('kantor', $kantor) // Filter by kantor (from users table)
        ->whereHas('salary', function ($query) use ($month, $year) {
            // Filter salaries by bulan (month) and tahun (year)
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        })
        ->with(['salary' => function ($query) use ($month, $year) {
            // Also filter the eager-loaded salaries by bulan and tahun
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        }])
        ->get();

        return view('place.kantor2', compact('users', 'month', 'year'));
    }
    public function filterAwak12(Request $request){
        $month = $request->input('bulan');
        $year = $request->input('tahun');
        $kantor = 'awak 1 dan awak 2';

        $users = User::where('kantor', $kantor) // Filter by kantor (from users table)
        ->whereHas('salary', function ($query) use ($month, $year) {
            // Filter salaries by bulan (month) and tahun (year)
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        })
        ->with(['salary' => function ($query) use ($month, $year) {
            // Also filter the eager-loaded salaries by bulan and tahun
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        }])
        ->get();

        return view('place.awak12', compact('users', 'month', 'year'));
    }
}
