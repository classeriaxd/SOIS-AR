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
    protected $viewDirectory = 'accomplishmentReports.excelTemplates.';

    // Contains all query information
    protected $table1; 
    protected $table2; 
    protected $table3; 
    protected $table4; 

    // Contains Table and Column Names
    protected $table1Columns;
    protected $table2Columns;
    protected $table3Columns;
    protected $table4Columns;

    // Set Number of Tables
    protected $totalTables = 4;

    /**
     * @param Collection $tables, Array $table1, Array $table2, Array $table3, Array $table4
     * Catches required parameters given from calling the class
     */ 
    public function __construct($tables, $table1, $table2, $table3, $table4)
    {
        // Set Protected class
        $this->tableDetails = $tables;
        $this->table1 = $table1;
        $this->table2 = $table2;
        $this->table3 = $table3;
        $this->table4 = $table4;
        $this->table1Columns = $tables[0];
        $this->table2Columns = $tables[1];
        $this->table3Columns = $tables[2];
        $this->table4Columns = $tables[3];
    }
   
    public function view(): View
    {
        return view($this->viewDirectory . 'tabularAccomplishmentReport', [
            'table1' => $this->table1,
            'table2' => $this->table2,
            'table3' => $this->table3,
            'table4' => $this->table4,

            'table1Columns' => $this->table1Columns,
            'table2Columns' => $this->table2Columns,
            'table3Columns' => $this->table3Columns,
            'table4Columns' => $this->table4Columns,
        ]);
    }

    public function registerEvents(): array
    {
        // Get Values from Parameter
        $table1 = $this->table1;
        $table2 = $this->table2;
        $table3 = $this->table3;
        $table4 = $this->table4;

        $table1Columns = $this->table1Columns->tabularColumns->count();
        $table2Columns = $this->table2Columns->tabularColumns->count();
        $table3Columns = $this->table3Columns->tabularColumns->count();
        $table4Columns = $this->table4Columns->tabularColumns->count();
        
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

                // Note: this loop required the variable format as above ^ ($table1, $table1Columns)
                // Loops on each table -> table{$i}, table{$i}Columns
                for ($i = 1; $i <= $this->totalTables; $i++) 
                { 
                    // Applies Style to the Headers
    
                        // Get Row Total
                        $row = $currentRow;
                        // Get Column Total
                        $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(${"table" . $i . "Columns"});

                        // Header 1
                        $event->sheet->getStyle('A'. $row. ':' . $column . $row)->applyFromArray([
                            'font' => [
                                'bold' => true,
                            'color' => [
                                    // TEXT COLOR
                                    'rgb' => 'FFFFFF'],
                            ],
                            'fill' => [
                                    // BACKGROUND COLOR 
                                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                   'startColor' => [
                                       'argb' => 'FF800000',
                                   ],
                                   'endColor' => [
                                       'argb' => 'FF800000',
                                   ],
                            ],
                        ]);

                        // Skip to next line to apply style to second header
                        $row += 1;

                        // Header 2
                        $event->sheet->getStyle('A'. $row. ':' . $column . $row)->applyFromArray([
                            'font' => [
                                'bold' => true,
                            'color' => [
                                    // TEXT COLOR
                                    'rgb' => 'FFFFFF'],
                            ],
                            'fill' => [
                                    // BACKGROUND COLOR 
                                   'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                   'startColor' => [
                                       'rgb' => '203763',
                                   ],
                                   'endColor' => [
                                       'rgb' => '203763',
                                   ],
                            ],
                        ]);

                    // Skip a line to have Break Space
                    if (${"table" . $i}->isNotEmpty()) 
                        $row += ${"table" . $i}->count() + 2;
                    else
                        $row += 2;

                    // Set current row to total appended rows
                    $currentRow = $row;
                }

                // Set Paper Settings
                $event->sheet->getDelegate()->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(PageSetup::PAPERSIZE_LETTER)
                    ->setFitToHeight(1)
                    ->setFitToWidth(1);
                
            }
        ];
    }
    
}
