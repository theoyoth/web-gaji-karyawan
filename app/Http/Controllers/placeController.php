<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class placeController extends Controller
{

    public function kantor1(){

      // Load users with their salaries, filtered by kantor
      $users = User::where('kantor', "kantor 1")
                    ->with('salary');

      // Step 2: Clone for total calculation (all data)
      $allUsers = (clone $users)->get();

      $totalUsersSalary = $allUsers->reduce(function ($totalValue, $user) {
        $salary = $user->salary;
        // if tabungan_hari_tua is needed, put it back in total general
        return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          // 'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, ['totalJumlahGaji' => 0,
      'totalTunjanganMakan' => 0,
      'totalPotonganBpjs' => 0,
      // 'totalPotonganHariTua' => 0,
      'totalPotonganKreditKasbon' => 0,
      'totalGeneral' => 0]);

      // Step 3: Paginate the original query
      $usersPaginate = $users->paginate(15);
      // calculate total of data paginate
      $pageTotals = $usersPaginate->reduce(function ($totalValue, $user) {
        $salary = $user->salary;

        return [
            'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
            'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
            'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
            // 'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
            'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
            'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, ['totalJumlahGaji' => 0,
      'totalTunjanganMakan' => 0,
      'totalPotonganBpjs' => 0,
      // 'totalPotonganHariTua' => 0,
      'totalPotonganKreditKasbon' => 0,
      'totalGeneral' => 0]);

      return view('place.kantor1', ['users'=>$usersPaginate,'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary]);
    }

    public function kantor2(){
      // Load users with their salaries, filtered by kantor
      $users = User::where('kantor', "kantor 2")
                  ->with('salary');

      // Step 2: Clone for total calculation (all data)
      $allUsers = (clone $users)->get();

      $totalUsersSalary = $allUsers->reduce(function ($totalValue, $user) {
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

      // Step 3: Paginate the original query
      $usersPaginate = $users->paginate(15);
      // calculate total of data paginate
      $pageTotals = $usersPaginate->reduce(function ($totalValue, $user) {
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

      return view('place.kantor2', ['users'=>$usersPaginate,'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary]);
    }

    public function awak12(){
        // Load users with their salaries, filtered by kantor
        $users = User::where('kantor', "awak 1 dan awak 2")
                    ->with('salary.deliveries');

        // Step 2: Clone for total calculation (all data)
        $allUsers = (clone $users)->get();

        $totalUsersSalary = $allUsers->reduce(function ($totalValue, $user) {
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

        // Step 3: Paginate the original query
        $usersPaginate = $users->paginate(15);
        // calculate total of data paginate
        $pageTotals = $usersPaginate->reduce(function ($totalValue, $user) {
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

        return view('place.awak12', ['users'=>$usersPaginate, 'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary]);
      }

      // FILTER controller
      public function filterKantor1(Request $request){
        $month = $request->input('bulan');
        $year = $request->input('tahun');
        $kantor = 'kantor 1';

        $query = User::where('kantor', $kantor) // Filter by kantor (from users table)
        ->whereHas('salary', function ($q) use ($month, $year) {
            // Filter salaries by bulan (month) and tahun (year)
            if ($month && $year) {
                $q->where('bulan', $month)
                      ->where('tahun', $year);
            }
        })
        ->with(['salary' => function ($q) use ($month, $year) {
            // Also filter the eager-loaded salaries by bulan and tahun
            if ($month && $year) {
                $q->where('bulan', $month)
                      ->where('tahun', $year);
            }
        }]);

        // Step 2: Clone for total calculation (all data)
      $allUsers = (clone $query)->get();
      // Step 3: Paginate the original query
      $usersPaginate = $query->paginate(15)->appends($request->only(['bulan', 'tahun']));

      $totalUsersSalary = $allUsers->reduce(function ($totalValue, $user) {
        $salary = $user->salary;
        return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, [
        'totalJumlahGaji' => 0,
        'totalTunjanganMakan' => 0,
        'totalPotonganBpjs' => 0,
        'totalPotonganHariTua' => 0,
        'totalPotonganKreditKasbon' => 0,
        'totalGeneral' => 0
      ]);

      // calculate total of data paginate
      $pageTotals = $usersPaginate->reduce(function ($totalValue, $user) {
        $salary = $user->salary;

        return [
            'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
            'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
            'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
            'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
            'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
            'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, [
        'totalJumlahGaji' => 0,
        'totalTunjanganMakan' => 0,
        'totalPotonganBpjs' => 0,
        'totalPotonganHariTua' => 0,
        'totalPotonganKreditKasbon' => 0,
        'totalGeneral' => 0
      ]);

      return view('place.kantor1', ['users'=>$usersPaginate,'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary,'month'=>$month,'year'=>$year]);
    }

    public function filterKantor2(Request $request){
      $month = $request->input('bulan');
      $year = $request->input('tahun');
      $kantor = 'kantor 2';

      $query = User::where('kantor', $kantor) // Filter by kantor (from users table)
      ->whereHas('salary', function ($q) use ($month, $year) {
          // Filter salaries by bulan (month) and tahun (year)
          if ($month && $year) {
              $q->where('bulan', $month)
                    ->where('tahun', $year);
          }
      })
      ->with(['salary' => function ($q) use ($month, $year) {
          // Also filter the eager-loaded salaries by bulan and tahun
          if ($month && $year) {
              $q->where('bulan', $month)
                    ->where('tahun', $year);
          }
      }]);

      // Step 2: Clone for total calculation (all data)
      $allUsers = (clone $query)->get();
      // Step 3: Paginate the original query
      $usersPaginate = $query->paginate(15)->appends($request->only(['bulan', 'tahun']));

      $totalUsersSalary = $allUsers->reduce(function ($totalValue, $user) {
        $salary = $user->salary;
        return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, [
        'totalJumlahGaji' => 0,
        'totalTunjanganMakan' => 0,
        'totalPotonganBpjs' => 0,
        'totalPotonganHariTua' => 0,
        'totalPotonganKreditKasbon' => 0,
        'totalGeneral' => 0
      ]);

      // calculate total of data paginate
      $pageTotals = $usersPaginate->reduce(function ($totalValue, $user) {
        $salary = $user->salary;

        return [
            'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
            'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
            'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
            'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
            'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
            'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, [
        'totalJumlahGaji' => 0,
        'totalTunjanganMakan' => 0,
        'totalPotonganBpjs' => 0,
        'totalPotonganHariTua' => 0,
        'totalPotonganKreditKasbon' => 0,
        'totalGeneral' => 0
      ]);

      return view('place.kantor2', ['users'=>$usersPaginate,'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary,'month'=>$month,'year'=>$year]);
    }

    public function filterAwak12(Request $request){
      $month = $request->input('bulan');
      $year = $request->input('tahun');
      $kantor = 'awak 1 dan awak 2';

      // Build query (do NOT call get() here)
      $query = User::where('kantor', $kantor)
          ->whereHas('salary', function ($query) use ($month, $year) {
              if ($month && $year) {
                  $query->where('bulan', $month)
                        ->where('tahun', $year);
              }
          })
          ->with(['salary' => function ($query) use ($month, $year) {
              if ($month && $year) {
                  $query->where('bulan', $month)
                        ->where('tahun', $year);
              }
          }]);

      // Clone for total calculation
      $allUsers = (clone $query)->get();

      // Paginate properly
      $usersPaginate = $query->paginate(15)->appends($request->only(['bulan', 'tahun']));

      // Calculate total for all data
      $totalUsersSalary = $allUsers->reduce(function ($total, $user) {
          $salary = $user->salary;

          return [
              'totalJumlahGaji' => $total['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
              'totalTunjanganMakan' => $total['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
              'totalJumlahRetase' => $total['totalJumlahRetase'] + ($salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase) ?? 0),
              'totalPotonganBpjs' => $total['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
              'totalPotonganHariTua' => $total['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
              'totalPotonganKreditKasbon' => $total['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
              'totalGeneral' => $total['totalGeneral'] + (($salary->jumlah_gaji ?? 0) - (($salary->potongan_bpjs ?? 0) + ($salary->potongan_hari_tua ?? 0) + ($salary->potongan_kredit_kasbon ?? 0))),
          ];
      }, [
          'totalJumlahGaji' => 0,
          'totalTunjanganMakan' => 0,
          'totalJumlahRetase' => 0,
          'totalPotonganBpjs' => 0,
          'totalPotonganHariTua' => 0,
          'totalPotonganKreditKasbon' => 0,
          'totalGeneral' => 0,
      ]);

      // Calculate total for current page
      $pageTotals = $usersPaginate->getCollection()->reduce(function ($total, $user) {
          $salary = $user->salary;

          return [
              'totalJumlahGaji' => $total['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
              'totalTunjanganMakan' => $total['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
              'totalJumlahRetase' => $total['totalJumlahRetase'] + ($salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase) ?? 0),
              'totalPotonganBpjs' => $total['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
              'totalPotonganHariTua' => $total['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
              'totalPotonganKreditKasbon' => $total['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
              'totalGeneral' => $total['totalGeneral'] + (($salary->jumlah_gaji ?? 0) - (($salary->potongan_bpjs ?? 0) + ($salary->potongan_hari_tua ?? 0) + ($salary->potongan_kredit_kasbon ?? 0))),
          ];
      }, [
          'totalJumlahGaji' => 0,
          'totalTunjanganMakan' => 0,
          'totalJumlahRetase' => 0,
          'totalPotonganBpjs' => 0,
          'totalPotonganHariTua' => 0,
          'totalPotonganKreditKasbon' => 0,
          'totalGeneral' => 0,
      ]);

      return view('place.awak12', [
          'users' => $usersPaginate,
          'month' => $month,
          'year' => $year,
          'pageTotals' => $pageTotals,
          'totalUsersSalary' => $totalUsersSalary,
      ]);
    }

    public function filterbyMonthAwak12(Request $request){
      $month = $request->input('bulan');
      $year = $request->input('tahun');
      $kantor = 'awak 1 dan awak 2';

      // Build query (do NOT call get() here)
      $query = User::where('kantor', $kantor)
          ->whereHas('salary', function ($query) use ($month, $year) {
              if ($month && $year) {
                  $query->where('bulan', $month)
                        ->where('tahun', $year);
              }
          })
          ->with(['salary' => function ($query) use ($month, $year) {
              if ($month && $year) {
                  $query->where('bulan', $month)
                        ->where('tahun', $year);
              }
          }]);

      // Clone for total calculation
      $allUsers = (clone $query)->get();

      // Paginate properly
      $usersPaginate = $query->paginate(15)->appends($request->only(['bulan','tahun']));

      // Calculate total for all data
      $totalUsersSalary = $allUsers->reduce(function ($total, $user) {
          $salary = $user->salary;

          return [
              'totalJumlahGaji' => $total['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
              'totalTunjanganMakan' => $total['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
              'totalJumlahRetase' => $total['totalJumlahRetase'] + ($salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase) ?? 0),
              'totalPotonganBpjs' => $total['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
              'totalPotonganHariTua' => $total['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
              'totalPotonganKreditKasbon' => $total['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
              'totalGeneral' => $total['totalGeneral'] + (($salary->jumlah_gaji ?? 0) - (($salary->potongan_bpjs ?? 0) + ($salary->potongan_hari_tua ?? 0) + ($salary->potongan_kredit_kasbon ?? 0))),
          ];
      }, [
          'totalJumlahGaji' => 0,
          'totalTunjanganMakan' => 0,
          'totalJumlahRetase' => 0,
          'totalPotonganBpjs' => 0,
          'totalPotonganHariTua' => 0,
          'totalPotonganKreditKasbon' => 0,
          'totalGeneral' => 0,
      ]);

      // Calculate total for current page
      $pageTotals = $usersPaginate->getCollection()->reduce(function ($total, $user) {
          $salary = $user->salary;

          return [
              'totalJumlahGaji' => $total['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
              'totalTunjanganMakan' => $total['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
              'totalJumlahRetase' => $total['totalJumlahRetase'] + ($salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase) ?? 0),
              'totalPotonganBpjs' => $total['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
              'totalPotonganHariTua' => $total['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
              'totalPotonganKreditKasbon' => $total['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
              'totalGeneral' => $total['totalGeneral'] + (($salary->jumlah_gaji ?? 0) - (($salary->potongan_bpjs ?? 0) + ($salary->potongan_hari_tua ?? 0) + ($salary->potongan_kredit_kasbon ?? 0))),
          ];
      }, [
          'totalJumlahGaji' => 0,
          'totalTunjanganMakan' => 0,
          'totalJumlahRetase' => 0,
          'totalPotonganBpjs' => 0,
          'totalPotonganHariTua' => 0,
          'totalPotonganKreditKasbon' => 0,
          'totalGeneral' => 0,
      ]);

      return view('place.awak12', [
          'users' => $usersPaginate,
          'month' => $month,
          'year' => $year,
          'pageTotals' => $pageTotals,
          'totalUsersSalary' => $totalUsersSalary,
      ]);
    }

    public function filterbyMonthKantor(Request $request){
      $month = $request->input('bulan');
      $year = $request->input('tahun');
      $kantor = $request->input('kantor');

      $query = User::where('kantor', $kantor) // Filter by kantor (from users table)
      ->whereHas('salary', function ($q) use ($month, $year) {
          // Filter salaries by bulan (month) and tahun (year)
          if ($month && $year) {
              $q->where('bulan', $month)
                ->where('tahun', $year);
          }
      })
      ->with(['salary' => function ($q) use ($month, $year) {
          // Also filter the eager-loaded salaries by bulan and tahun
          if ($month && $year) {
              $q->where('bulan', $month)
                ->where('tahun', $year);
          }
      }]);

      // Step 2: Clone for total calculation (all data)
      $allUsers = (clone $query)->get();
      // Step 3: Paginate the original query
      $usersPaginate = $query->paginate(15)->appends($request->only(['bulan','tahun','kantor']));

      $totalUsersSalary = $allUsers->reduce(function ($totalValue, $user) {
        $salary = $user->salary;
        return [
          'totalGajiPokok' => $totalValue['totalGajiPokok'] + ($salary->gaji_pokok ?? 0),
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          // 'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - (($salary->potongan_bpjs ?? 0) + ($salary->potongan_kredit_kasbon ?? 0))),
        ];
      }, [
        'totalGajiPokok' => 0,
        'totalJumlahGaji' => 0,
        'totalTunjanganMakan' => 0,
        'totalPotonganBpjs' => 0,
        // 'totalPotonganHariTua' => 0,
        'totalPotonganKreditKasbon' => 0,
        'totalGeneral' => 0
      ]);

      // calculate total of data paginate
      $pageTotals = $usersPaginate->reduce(function ($totalValue, $user) {
        $salary = $user->salary;

        return [
            'totalGajiPokok' => $totalValue['totalGajiPokok'] + ($salary->gaji_pokok ?? 0),
            'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
            'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
            'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
            // 'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
            'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
            'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_kredit_kasbon) ?? 0),
        ];
      }, [
        'totalGajiPokok' => 0,
        'totalJumlahGaji' => 0,
        'totalTunjanganMakan' => 0,
        'totalPotonganBpjs' => 0,
        // 'totalPotonganHariTua' => 0,
        'totalPotonganKreditKasbon' => 0,
        'totalGeneral' => 0
      ]);

      if($kantor === 'kantor 1'){
        return view('place.kantor1', ['users'=>$usersPaginate,'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary,'month'=>$month,'year'=>$year]);
      }
      else if($kantor === 'kantor 2'){
        return view('place.kantor2', ['users'=>$usersPaginate,'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary,'month'=>$month,'year'=>$year]);
      }
    }

  public function filterbyMonthOperatorHelper(Request $request){
    $month = $request->input('bulan');
    $year = $request->input('tahun');
    $kantor = 'operator dan helper';

    $query = User::where('kantor', $kantor) // Filter by kantor (from users table)
    ->whereHas('salary', function ($q) use ($month, $year) {
        // Filter salaries by bulan (month) and tahun (year)
        if ($month && $year) {
            $q->where('bulan', $month)
              ->where('tahun', $year);
        }
    })
    ->with(['salary' => function ($q) use ($month, $year) {
        // Also filter the eager-loaded salaries by bulan and tahun
        if ($month && $year) {
            $q->where('bulan', $month)
              ->where('tahun', $year);
        }
    }]);

    // Step 2: Clone for total calculation (all data)
    $allUsers = (clone $query)->get();
    // Step 3: Paginate the original query
    $usersPaginate = $query->paginate(15)->appends($request->only(['bulan', 'tahun','kantor']));

    $totalUsersSalary = $allUsers->reduce(function ($totalValue, $user) {
      $salary = $user->salary;
      return [
        'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
        'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
        'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
        'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
        'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
        'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
      ];
    }, [
      'totalJumlahGaji' => 0,
      'totalTunjanganMakan' => 0,
      'totalPotonganBpjs' => 0,
      'totalPotonganHariTua' => 0,
      'totalPotonganKreditKasbon' => 0,
      'totalGeneral' => 0
    ]);

    // calculate total of data paginate
    $pageTotals = $usersPaginate->reduce(function ($totalValue, $user) {
      $salary = $user->salary;

      return [
          'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
          'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
          'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
          'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
          'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
          'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
      ];
    }, [
      'totalJumlahGaji' => 0,
      'totalTunjanganMakan' => 0,
      'totalPotonganBpjs' => 0,
      'totalPotonganHariTua' => 0,
      'totalPotonganKreditKasbon' => 0,
      'totalGeneral' => 0
    ]);

    if($kantor === 'kantor 1'){
      return view('place.kantor1', ['users'=>$usersPaginate,'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary,'month'=>$month,'year'=>$year]);
    }
    else if($kantor === 'kantor 2'){
      return view('place.kantor2', ['users'=>$usersPaginate,'pageTotals'=>$pageTotals,'totalUsersSalary'=>$totalUsersSalary,'month'=>$month,'year'=>$year]);
    }
  }
}
