<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function kantor1(Request $request){

        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "kantor 1")
                    ->with('salaries')
                    ->get();
    
        return view('print.kantor1', compact('users'));
    }

    public function kantor2(){
        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "kantor 2")
                    ->with('salaries')
                    ->get();
    
        return view('print.kantor2', compact('users'));
    }
    public function awak12(){
        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "awak 1 dan awak 2")
                    ->with('salaries')
                    ->get();
    
        return view('print.awak12', compact('users'));
    }
}
