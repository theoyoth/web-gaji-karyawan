<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;

class Awak12Export implements FromView, WithStyles
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }
    public function view(): View
    {
        // $users = User::where('kantor', "awak 1 dan awak 2")
        //   ->with(['salary.deliveries' => function ($query) {
        //       $query->whereMonth('bulan', $this->bulan)
        //             ->whereYear('tahun', $this->tahun);
        //   }])
        //   ->whereHas('salary.deliveries', function ($query) {
        //       $query->whereMonth('bulan', $this->bulan)
        //             ->whereYear('tahun', $this->tahun);
        //   })
        //   ->get();

          

        $query = User::where('kantor', "awak 1 dan awak 2")
            ->whereHas('salary', function ($q) {
                    $q->where('bulan', $this->month)
                      ->where('tahun', $this->year);
                }
            )
            ->with(['salary' => function ($q) {
                    $q->where('bulan', $this->month)
                      ->where('tahun', $this->year);
                }
            ]);

        $users = $query->get();

      return view('export.awak12-excel', [
          'users' => $users,
          'month' => $this->month,
          'year' => $this->year,
      ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'EEEEEE']
                ],
            ],
        ];
    }
}