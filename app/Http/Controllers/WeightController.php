<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class WeightController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

   /**
     * Fetch all weights.
     *
     * @return void
     */
    public function all(Request $request)
    {
        $wieghts = $request->user()->weights->all();

        return response()->json($wieghts);
    }

}
