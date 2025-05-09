<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function kantor1(Request $request){

        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "kantor 1")
                    ->with('salary')
                    ->get();

        $totalUsersSalary = $users->reduce(function ($totalValue, $user) {
        $salary = $user->salary;

        return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
        }, ['totalJumlahGaji' => 0, 'totalTunjanganMakan' => 0, 'totalPotonganBpjs' => 0,'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);

        return view('print.kantor1', ['users' => $users, 'totalUsersSalary' => $totalUsersSalary]);
    }

    public function kantor2(){
      // Load users with their salaries, filtered by kantor
      $users = User::where('kantor', "kantor 2")
                  ->with('salary')
                  ->get();

      $totalUsersSalary = $users->reduce(function ($totalValue, $user) {
      $salary = $user->salary;

      return [
        'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
        'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
        'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
        'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
        'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
        'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
      ];
      }, ['totalJumlahGaji' => 0, 'totalTunjanganMakan' => 0, 'totalPotonganBpjs' => 0,'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);

      return view('print.kantor2', ['users' => $users, 'totalUsersSalary' => $totalUsersSalary]);
    }
    public function awak12(){
      // Load users with their salaries, filtered by kantor
      $users = User::where('kantor', "awak 1 dan awak 2")
                  ->with('salary')
                  ->get();

      $totalUsersSalary = $users->reduce(function ($totalValue, $user) {
        $salary = $user->salary;
        return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalJumlahRetase' => $totalValue['totalJumlahRetase'] + ($salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase) ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, ['totalJumlahGaji' => 0, 'totalTunjanganMakan' => 0, 'totalJumlahRetase' => 0, 'totalPotonganBpjs' => 0,'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);


      return view('print.awak12', ['users' => $users, 'totalUsersSalary' => $totalUsersSalary]);
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

      $totalUsersSalary = $users->reduce(function ($totalValue, $user) {
        $salary = $user->salary;

        return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, ['totalJumlahGaji' => 0, 'totalTunjanganMakan' => 0, 'totalPotonganBpjs' => 0,'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);

      return view('print.kantor1', ['users' => $users, 'month' => $month, 'year' => $year,'totalUsersSalary'=>$totalUsersSalary]);
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

      $totalUsersSalary = $users->reduce(function ($totalValue, $user) {
        $salary = $user->salary;

        return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, ['totalJumlahGaji' => 0, 'totalTunjanganMakan' => 0, 'totalPotonganBpjs' => 0,'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);

      return view('print.kantor2', ['users' => $users, 'month' => $month, 'year' => $year,'totalUsersSalary'=>$totalUsersSalary]);
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

      $totalUsersSalary = $users->reduce(function ($totalValue, $user) {
        $salary = $user->salary;

        return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalJumlahRetase' => $totalValue['totalJumlahRetase'] + ($salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase) ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, ['totalJumlahGaji' => 0, 'totalTunjanganMakan' => 0, 'totalJumlahRetase' => 0, 'totalPotonganBpjs' => 0,'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);


      return view('print.awak12', ['users' => $users, 'month' => $month, 'year' => $year,'totalUsersSalary'=>$totalUsersSalary]);
  }
}
