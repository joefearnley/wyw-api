<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class WeightController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $this->request = $request;
    }

   /**
     * Fetch all weights.
     *
     * @return void
     */
    public function index()
    {
        $weights = $this->request->user()->weights->all();

        return response()->json($weights, 200);
    }

    public function create()
    {
        $this->validate($this->request, [
            'weight' => 'required|numeric',
            'weigh_in_date' => 'required|date'
        ]);

        $weight = $this->request->user()->weights()->create($this->request->all());

        return response()->json($weight, 200);
    }

}
