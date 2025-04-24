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

    public function filterKantor1(Request $request){
        $month = $request->input('bulan');
        $year = $request->input('tahun');

        $users = User::with(['salaries' => function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->where('bulan', $month)
                      ->where('tahun', $year);
            } else {
                // If either month or year is missing, return nothing
                $query->whereRaw('0 = 1');
            }
        }])->get();

        return view('place.kantor1', compact('users', 'month', 'year'));
    }
}
