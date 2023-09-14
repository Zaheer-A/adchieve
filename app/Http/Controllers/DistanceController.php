<?php

namespace App\Http\Controllers;

use App\Models\Address;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use function Sodium\add;

class DistanceController extends Controller
{
    public $distancesCalculated = false;

    public function calculateGivenAddressesDistances()
    {
//        if($this->distancesCalculated) {
//            //generate csv and echo out distances
//        }

        $addresses = Address::getEightWonders();
        $headquarters = Address::getHeadQuarters();

        $distances = [];
        $client = new Client();

        foreach ($addresses as $address) {
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$address->address}&destinations={$headquarters->address}&key=" . env('GOOGLE_DISTANCE_MATRIX_API_KEY');
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            if ($response->getStatusCode() === 200 && isset($data['rows'][0]['elements'][0]['distance']['text'])) {
                $distance = round($data['rows'][0]['elements'][0]['distance']['value'] / 1000, 2);
                $address->distance = $distance;
                $address->save();
                $distances[] = [
                    'address' => $address,
                    'distance' => $distance,
                ];
            } else {
                // Handle the case where the response is not as expected
                $distances[] = [
                    'address' => $address,
                    'distance' => null,
                ];
            }
        }

        $this->distancesCalculated = true;
    }

    private function generateCsv($distances)
    {
        $csvData = [];
        foreach ($distances as $address => $distance) {
            $csvData[] = [$address, $distance];
        }

        Excel::create('distances.csv', function ($excel) use ($csvData) {
            $excel->sheet('Sheet1', function ($sheet) use ($csvData) {
                $sheet->fromArray($csvData);
            });
        })->export('csv');
    }


}
