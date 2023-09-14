<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['address', 'type', 'distance'];

    /**
     * Get the first available current headquarters
     * @return Address the current headquarters if available, otherwise it makes a new one.
     */
    public static function getHeadquarters() : Address
    {
        return Address::where('type', 'headquarters')->firstOrCreate(
            ['address' => 'Adchieve HQ - Sint Janssingel 92, 5211 DA \'s-Hertogenbosch, The Netherlands'],
            ['type' => 'headquarters'],
            ['distance' => 0.00]
        );
    }


    public static function getEightWonders()
    {
        return Address::where('type', 'given')->get();
    }


}
