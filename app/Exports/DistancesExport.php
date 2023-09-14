<?php

namespace App\Exports;

use App\Models\Address;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DistancesExport implements FromCollection
{

    public function collection()
    {
        return Address::getAllAddressesSorted();
    }

    public function headings(): array
    {
        return [
            'Address',
            'Distance (km)',
        ];
    }
}
