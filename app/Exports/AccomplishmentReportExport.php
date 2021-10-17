<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\{
    FromView,
    ShouldAutoSize,
    WithEvents,
};

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class AccomplishmentReportExport implements 
    FromView, 
    ShouldAutoSize,
    WithEvents
{

    protected $table1; protected $table1Columns = 7;
    protected $table2; protected $table2Columns = 7;
    protected $table3; protected $table3Columns = 15;
    protected $table4; protected $table4Columns = 15;

    public function __construct($table1, $table2, $table3, $table4)
    {
        $this->table1 = $table1;
        $this->table2 = $table2;
        $this->table3 = $table3;
        $this->table4 = $table4;
    }
   
    public function view(): View
    {
        return view('accomplishmentreports.excelTemplates.tabularAccomplishmentReport', [
            'table1' => $this->table1,
            'table2' => $this->table2,
            'table3' => $this->table3,
            'table4' => $this->table4,
        ]);
    }

    public function registerEvents(): array
    {
        $table1 = $this->table1; $table1Columns = $this->table1Columns;
        $table2 = $this->table2; $table2Columns = $this->table2Columns;
        $table3 = $this->table3; $table3Columns = $this->table3Columns;
        $table4 = $this->table4; $table4Columns = $this->table4Columns;

        return [
            AfterSheet::class => function(AfterSheet $event) 
            use (
                $table1, 
                $table2, 
                $table3, 
                $table4,
                $table1Columns,
                $table2Columns,
                $table3Columns,
                $table4Columns,
            )
            {
                $currentRow = 1;
                for ($i = 1; $i <= 3; $i++) 
                { 
                    // Apply Styles to Headers
                    // TABLE { $i }
                        // Get Row Total
                        $row = $currentRow;
                        // Get Column Total
                        $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(${"table" . $i . "Columns"});
                        // Header 1
                        $event->sheet->getStyle('A'. $row. ':' . $column . $row)->applyFromArray([
                            'font' => [
                                'bold' => true,
                            'color' => [
                                    'rgb' => 'FFFFFF'],
                            ],
                            'fill' => [
                                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                   'startColor' => [
                                       'argb' => 'FF800000',
                                   ],
                                   'endColor' => [
                                       'argb' => 'FF800000',
                                   ],
                            ],
                        ]);

                        $row += 1;

                        // Header 2
                        $event->sheet->getStyle('A'. $row. ':' . $column . $row)->applyFromArray([
                            'font' => [
                                'bold' => true,
                            'color' => [
                                    'rgb' => 'FFFFFF'],
                            ],
                            'fill' => [
                                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                   'startColor' => [
                                       'argb' => '203763',
                                   ],
                                   'endColor' => [
                                       'argb' => '203763',
                                   ],
                            ],
                        ]);
                    if (${"table" . $i}->isNotEmpty()) 
                        $row += ${"table" . $i}->count() + 2;
                    else
                        $row += 2;

                    $currentRow = $row;
                }
                $event->sheet->getDelegate()->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(PageSetup::PAPERSIZE_LETTER)
                    ->setFitToHeight(1)
                    ->setFitToWidth(1);
                
            }
        ];
    }
    
}
