<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class WeightsController extends Controller
{
   /**
     * Fetch all weights from the Firebase API.
     *
     * @return void
     */
    public function all()
    {
        return response()->json(Weight::all());
    }
}
