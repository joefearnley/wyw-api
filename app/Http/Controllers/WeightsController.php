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

        // dd($this->fireBaseUrl);
    }

    public function index()
    {
        $client = new GuzzleHttp\Client();
        $result = $client->request('GET', $this->fireBaseUrl);

        dd($result);

    }
}
