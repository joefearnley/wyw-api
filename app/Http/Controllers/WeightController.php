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
        $weights = $request->user()->weights->all();

        return response()->json($wieghts, 200);
    }

    public function create(Request $request)
    {
        $weight = $request->user()->weights->create($request->all());

        return response()->json($weight, 200);
    }

}
