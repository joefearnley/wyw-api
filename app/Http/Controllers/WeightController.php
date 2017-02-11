<?php

namespace App\Http\Controllers;

use App\Weight;
use Carbon\Carbon;

class WeightController extends Controller
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

    public function save()
    {
        Weight::create([
            'weight' => 175,
            'weigh_in_date' => date('Y-m-d', strtotime('1/30/2017')),
            'user_id' => 1
        ]);

        Weight::create([
            'weight' => 170,
            'weigh_in_date' => date('Y-m-d ', strtotime('2/30/2017')),
            'user_id' => 1
        ]);

        Weight::create([
            'weight' => 165,
            'weigh_in_date' => date('Y-m-d', strtotime('3/30/2017')),
            'user_id' => 1
        ]);
    }
}
