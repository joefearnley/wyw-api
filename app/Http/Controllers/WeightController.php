<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Weight;

class WeightController extends Controller
{
    protected $request;

    /**
     * Create an instance of the WeightController class.
     * 
     * @param Request
     */
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

    /**
     * Create a Weight record.
     * 
     * @return Illuminate\Http\JsonResponse;
     */
    public function create()
    {
        $this->validate($this->request, [
            'weight' => 'required|numeric',
            'weigh_in_date' => 'required|date'
        ]);

        $weight = $this->request->user()->weights()->create($this->request->all());

        return response()->json($weight, 200);
    }

    /**
     *  Delete a Weight Record.
     * 
     * @param  int $id
     * @return Illuminate\Http\JsonReponse;
     */
    public function delete($id)
    {
        $weight = Weight::find($id);

        $weight->delete();

        return response()->json('Weight deleted.', 200);
    }

}
