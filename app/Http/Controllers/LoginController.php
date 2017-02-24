<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
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

    /**
     *  Authenticate (login) a user and return an api token.
     * 
     * @return Illuminate\Http\JsonResponse;
     */
    public function login()
    {
        $this->validate($this->request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

         if (!Auth::attempt($this->request->only('email', 'passwword'))) {
            return response()->json($response, 200);
         }

        $user = $this->authenticateUser();

        $response = [
            'token' => ''
        ];

        return response()->json($response, 200);
    }


}
