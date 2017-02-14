<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Weight;
use Carbon\Carbon;

class WeightController extends Controller
{
    protected $weight;

    protected $user;

    public function __construct(Weight $weight, User $user)
    {
        $this->middleware('auth');
        $this->weight = $weight;
        $this->user = $user;
    }

   /**
     * Fetch all weights.
     *
     * @return void
     */
    public function all(Request $request)
    {
        echo '<pre>';
        var_dump('safdasdfds');
        die();

        //$user = User::where('api_')

        return response()->json($this->weight->all());
    }

}
