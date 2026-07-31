<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RebarRequirementTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'site_id' => '1',
                'structural_element' => 'BEAM',
                'bar_diameter' => '16',
                'steel_grade' => '500',
                'required_length' => '6.0',
                'quantity' => '10',
                'drawing_reference' => 'ST-05 Rev.2',
                'remarks' => 'Main beam reinforcement',
            ],
            [
                'site_id' => '1',
                'structural_element' => 'Slab',
                'bar_diameter' => '12',
                'steel_grade' => '400',
                'required_length' => '3.5',
                'quantity' => '25',
                'drawing_reference' => 'SL-01',
                'remarks' => 'Slab mesh',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'site_id',
            'structural_element',
            'bar_diameter',
            'steel_grade',
            'required_length',
            'quantity',
            'drawing_reference',
            'remarks',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
