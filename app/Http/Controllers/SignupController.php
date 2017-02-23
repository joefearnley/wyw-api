<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class SignupController extends Controller
{
    /**
     * Http request for controller.
     * 
     * @var Illuminate\Http\Request;
     */
    protected $request;

    /**
     * Create an instance of the SignupController class.
     * 
     * @param Request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function signup()
    {
        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = new User($this->request->all());
        $user->password = Hash::make($this->request->input('password'));
        $user->api_token = str_random(60);
        $user->save();

        $response = [
            'message' => 'Signup complete.',
            'token' => $user->api_token
        ];

        return response()->json($response, 200);
    }

}
