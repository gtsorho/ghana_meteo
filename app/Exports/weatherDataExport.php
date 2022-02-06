<?php

namespace App\Exports;

use App\Models\weatherdata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;

class weatherDataExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    use Exportable;

    protected $data;

    function __construct($data) {
            $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function map($weatherdata): array
    {
        return [
            $weatherdata->id,
            $weatherdata->temperature,
            $weatherdata->datentime,
            $weatherdata->timeofday,
            $weatherdata->weather,
            $weatherdata->location,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'temperature',
            'datentime',
            'timeofday',
            'weather',
            'location',
        ];
    }

    public function registerEvents(): array
    {
        return [
            
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet->styleCells(
                    'B2:E8',
                    [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ]
                    ]
                );
            },
        ];
    }

    // public function registerEvents(): array
    // {
    //     return [
            
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $event->sheet->styleCells(
    //                 'A1:F1',
    //                 [
    //                     'font' => ['bold' => true]
    //                 ]
    //             );
    //         },
    //     ];
    // }
}
