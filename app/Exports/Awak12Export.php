<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Contracts\View\View;

class Awak12Export implements FromView, WithStyles, ShouldAutoSize
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
        $query = Employee::where('kantor', "awak 1 dan awak 2")
            ->whereHas('salaries', function ($q) {
                    $q->where('bulan', $this->month)
                      ->where('tahun', $this->year);
                }
            )
            ->with(['salaries' => function ($q) {
                    $q->where('bulan', $this->month)
                      ->where('tahun', $this->year)
                      ->with('deliveries'); // load deliveries
                }
            ]);

        $employees = $query->get();

      return view('export.awak12-excel', [
          'employees' => $employees,
          'month' => $this->month,
          'year' => $this->year,
      ]);
    }

    public function styles(Worksheet $sheet)
    {
      $lastColumn = $sheet->getHighestColumn();
      $lastRow = $sheet->getHighestRow();

      $sheet->getStyle("A1:{$lastColumn}{$lastRow}")
          ->getBorders()
          ->getAllBorders()
          ->setBorderStyle(Border::BORDER_THIN);

      return [
          1 => [
              'font' => ['bold' => true],
              'fill' => [
                  'fillType' => Fill::FILL_SOLID,
                  'startColor' => ['rgb' => 'a6a6a6']
              ],
              'alignment' => [
                  'horizontal' => Alignment::HORIZONTAL_CENTER,
                  'vertical' => Alignment::VERTICAL_CENTER,
              ],
          ],
          2 => [
              'font' => ['bold' => true],
              'fill' => [
                  'fillType' => Fill::FILL_SOLID,
                  'startColor' => ['rgb' => 'a6a6a6']
              ],
              'alignment' => [
                  'horizontal' => Alignment::HORIZONTAL_CENTER,
                  'vertical' => Alignment::VERTICAL_CENTER,
              ],
          ],
      ];
    }
}