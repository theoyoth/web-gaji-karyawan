<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;

class placeController extends Controller
{

    public function kantor1(Request $request){

        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "kantor 1")
                    ->with('salaries')
                    ->get();

        return view('place.kantor1', compact('users'));
    }

    public function kantor2(){
        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "kantor 2")
                    ->with('salaries')
                    ->get();

        return view('place.kantor2', compact('users'));
    }
    public function awak12(){
        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "awak 1 dan awak 2")
                    ->with('salaries')
                    ->get();

        return view('place.awak12', compact('users'));
    }


    // FILTER controller
    public function filterKantor1(Request $request){
        $month = $request->input('bulan');
        $year = $request->input('tahun');
        $kantor = 'kantor 1';

        $users = User::where('kantor', $kantor) // Filter by kantor (from users table)
        ->whereHas('salaries', function ($query) use ($month, $year) {
            // Filter salaries by bulan (month) and tahun (year)
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        })
        ->with(['salaries' => function ($query) use ($month, $year) {
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
        ->whereHas('salaries', function ($query) use ($month, $year) {
            // Filter salaries by bulan (month) and tahun (year)
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        })
        ->with(['salaries' => function ($query) use ($month, $year) {
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
        ->whereHas('salaries', function ($query) use ($month, $year) {
            // Filter salaries by bulan (month) and tahun (year)
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            }
        })
        ->with(['salaries' => function ($query) use ($month, $year) {
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
