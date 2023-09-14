<?php

namespace App\Http\Controllers;

use App\Exports\DistancesExport;
use App\Models\Address;
use GuzzleHttp\Client;
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

        $client = new Client();

        foreach ($addresses as $address) {
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$address->address}&destinations={$headquarters->address}&key=" . env('GOOGLE_DISTANCE_MATRIX_API_KEY');
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            if ($response->getStatusCode() === 200 && isset($data['rows'][0]['elements'][0]['distance']['text'])) {
                $distance = round($data['rows'][0]['elements'][0]['distance']['value'] / 1000, 2);
                $address->distance = $distance;
                $address->save();
            } else {
                // Handle the case where the response is not as expected by using positionStack instead
                $address->distance = null;
                $address->save();
            }
        }

        $this->distancesCalculated = true;

        $this->generateCsv();

    }

    private function generateCsv()
    {
        $fileName = 'distances_' . date('YmdHis') . '.csv';
        return Excel::store(new DistancesExport(),  'exports/' . $fileName, 'local');
    }
}
