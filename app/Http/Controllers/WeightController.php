<?php

namespace App\Http\Controllers;

use App\Weight;
use Carbon\Carbon;

class WeightController extends Controller
{
    protected $weight;

    public function __construct(Weight $weight)
    {
        $this->weight = $weight;
    }

   /**
     * Fetch all weights.
     *
     * @return void
     */
    public function all()
    {
        return response()->json($this->weight->all());
    }

}
