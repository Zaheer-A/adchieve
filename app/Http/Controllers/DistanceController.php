<?php

namespace App\Http\Controllers;

use App\Exports\DistancesExport;
use App\Models\Address;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;
use function Sodium\add;

class DistanceController extends Controller
{
    public bool $distancesCalculated = false;

    public function calculateGivenAddressesDistances()
    {
        if($this->distancesCalculated) {
            $this->generateCsv();
        }

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
                if(empty($addresses->latitude)) {
                    $url = "http://api.positionstack.com/v1/forward?access_key=" . env('POSITIONSTACK_API_KEY') . "&query={$address->address}";
                    $response = $client->get($url);
                    $data = json_decode($response->getBody());

                    if(property_exists($data, 'data') && is_array($data->data) && isset($data->data[0])) {
                        $address->latitude = $data->data[0]->latitude;
                        $address->longitude = $data->data[0]->longitude;

                        $address->distance = $this->calculateStraightLineDistance($address);
                    } else {
                        $address->distance = null;
                    }
                }
                $address->save();
            }
        }

        $this->distancesCalculated = true;

        $this->generateCsv();

    }

    private function generateCsv()
    {
        $fileName = 'distances_' . date('YmdHis') . '.csv';
        $addresses = Address::getAllAddressesSorted();
        return Excel::store(new DistancesExport($addresses),  'exports/' . $fileName, 'local');
    }

    /**
     * @param $location Of the location we want the distance of from the headquarters
     * @return float|int the distance in km
     */
    private function calculateStraightLineDistance($location): float|int
    {
        $headquarters = Address::getHeadquarters();
        $lat1 = deg2rad($location->latitude);
        $lng1 = deg2rad($location->longitude);
        $lat2 = deg2rad($headquarters->latitude);
        $lng2 = deg2rad($headquarters->longitude);

        $earthRadius = 6371; // Radius of the Earth in kilometers

        $deltaLat = $lat2 - $lat1;
        $deltaLng = $lng2 - $lng1;

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1) * cos($lat2) * sin($deltaLng / 2) * sin($deltaLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
