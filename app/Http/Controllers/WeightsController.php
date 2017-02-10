<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class WeightsController extends Controller
{
    private $fireBaseUrl;

    private $fireBaseConfig;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fireBaseUrl = ;

        $this->$fireBaseConfig = new \Geckob\Firebase\Firebase('path_to_your_secret_file.json');
    }

   /**
     * Fetch all weights from the Firebase API.
     *
     * @return void
     */
    public function all()
    {
        $client = new Client();
        $response = $client->get($this->fireBaseUrl);

        return response()->json(
            json_decode($response->getBody(), true)
        );
    }
}
