<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthenticateController extends Controller
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
    public function authenticate()
    {
        $this->validate($this->request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = $this->authenticateUser();

        if (!$user) {
            return response()->json(['Credentials do not match our records.'], 401);
         }

        $user->api_token = str_random(60);
        $user->save();

        $response = [
            'token' => $user->api_token
        ];

        return response()->json($response, 200);
    }

    /**
     * Make sure user is who they say they are.
     * 
     * @return App\User | bool
     */
    public function authenticateUser()
    {
        $user = User::where('email', $this->request->input('email'))->first();

        if ($user) {
            if (Hash::check($this->request->password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

}
