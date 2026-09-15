<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OffcutTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'offcut_code',
            'site_id',
            'bar_diameter',
            'length',
            'quantity',
            'storage_location',
            'status',
            'remarks',
        ];
    }

    public function array(): array
    {
        return [
            [
                'OC-2026-0001',
                1,
                16,
                6000,
                1,
                'Warehouse A',
                'Available',
                'Sample offcut from column cut',
            ],
        ];
    }
}
