<?php

namespace App\Exports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Subscription::subReport();
    }

    public function headings(): array
    {
        return [
            'App',
            'Event',
            'OS',
            'Total Event'
        ];
    }
}
