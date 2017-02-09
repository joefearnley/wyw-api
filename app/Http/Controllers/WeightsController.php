<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class WeightsController extends Controller
{
    private $fireBaseUrl;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fireBaseUrl = env('FIREBASE_URL');
    }

    public function index()
    {
        $client = new Client();
        $response = $client->get($this->fireBaseUrl);

        return response()->json(
            json_decode($response->getBody(), true)
        );
    }
}
