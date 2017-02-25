<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterController extends Controller
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
     *  Sign up and create a user.
     * 
     * @return Illuminate\Http\JsonResponse;
     */
    public function register()
    {
        $this->validateRequest();

        $user = $this->createUser();

        $response = [
            'message' => 'Signup complete.',
            'token' => $user->api_token
        ];

        return response()->json($response, 200);
    }

    /**
     *  Create user based on request input.
     * 
     * @return App\User
     */
    protected function createUser()
    {
        $user = new User($this->request->all());
        $user->password = Hash::make($this->request->input('password'));
        $user->api_token = str_random(60);
        $user->save();

        return $user;
    }

    /**
     *  Validate required data from request.
     * 
     * @return void
     */
    protected function validateRequest()
    {
        $this->validate($this->request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
    }

}
