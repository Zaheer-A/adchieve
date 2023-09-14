<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $addresses = [
            [
                'address' => 'Adchieve HQ - Sint Janssingel 92, 5211 DA \'s-Hertogenbosch, The Netherlands',
                'distance' => 0.00,
                'type' => 'headquarters',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'Eastern Enterprise B.V. Deldenerstraat 70, 7551AH Hengelo, The Netherlands',
                'distance' => null,
                'type' => 'other',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'Eastern Enterprise - 46/1 Office no 1 Ground Floor, Dada House, Inside dada silk mills compound, Udhana Main Rd, near Chhaydo Hospital, Surat, 394210, India',
                'distance' => null,
                'type' => 'other',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'Adchieve Rotterdam - Weena 505, 3013 AL Rotterdam, The Netherlands',
                'distance' => null,
                'type' => 'other',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'Sherlock Holmes - 221B Baker St., London, United Kingdom',
                'distance' => null,
                'type' => 'other',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'The White House 1600 Pennsylvania Avenue, Washington, D.C., USA',
                'distance' => null,
                'type' => 'other',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'The Empire State Building 350 Fifth Avenue, New York City, NY 10118',
                'distance' => null,
                'type' => 'other',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'The Pope - Saint Martha House, 00120 Citta del Vaticano, Vatican City',
                'distance' => null,
                'type' => 'other',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'address' => 'Neverland 5225 Figueroa Mountain Road, Los Olivos, Calif. 93441, USA',
                'distance' => null,
                'type' => 'other',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insert the dummy data into the 'addresses' table
        DB::table('addresses')->insert($addresses);
    }
}
