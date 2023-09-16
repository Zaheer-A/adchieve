<?php

namespace App\Exports;

use App\Models\Address;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DistancesExport implements FromCollection, WithHeadings
{
    protected Collection $addresses;

    public function __construct(Collection $addresses)
    {
        $this->addresses = $addresses;
    }

    public function collection(): Collection
    {
        $sortNumber = 0;
        echo "Sortnumber | Distance | Address <br/>";
        echo "------------------------------------------------------------------- <br/>";
        return $this->addresses->map(function ($address) use (&$sortNumber){
           $sortNumber++;
           $distanceText = ($address->distance != null) ? $address->distance . ' km' : 'N/A';
           $name = $address->address;
           echo $sortNumber . ", " . $distanceText . ", " . $name . "<br/>";
           return [$sortNumber, $distanceText, $name];
        });
    }

    public function headings(): array
    {
        return [
            ['Sortnumber', 'Distance', 'Address'],
        ];
    }
}
