<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Google Distance Matrix API Key
    |--------------------------------------------------------------------------
    |
    | Retrieve the Google api key set up to use the distance matrix api
    |
    */

    'google_distance_api_key' => env('GOOGLE_DISTANCE_MATRIX_API_KEY')

    ];
