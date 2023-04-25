<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\AuthHelper;
use App\Services\UserService;

class LoginController extends Controller
{
    //
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function loginGet()
    {
        return redirect('/')->with('loginFailure', 'loginFailure')->withErrors('Jelentkezz be!');
    }
    protected function login(Request $request)
    {
        $validator = $this->userService->validateLogin($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = $this->userService->login($validator);
        if ($user != null) {
            $token = $this->userService->createToken($user);
            return response()->json(["API Token" => $token, "User" => $user], 200);
        } else {
            $resp = 'Hibás felhasználónév/jeszó';
            return response()->json($resp, 401);
        }
    }
    /**
     * Handle account registration request
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->userService->validateRegister($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = $this->userService->register($validator);
        return response()->json($user, 200);
    }
    public function profileModify(Request $request)
    {
        if ($this->userService->passwordChecker($request->input('old_password'))) {
            return \response()->json("Hibás jelszó", 401);
        }
        $validator = $this->userService->validateProfileModify($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $response = $this->userService->profileModify($request);
        return response()->json($response);
    }
    public function logout()
    {
        $this->userService->logoutAPI();
        Session::flush();

        return response()->json('logged out, tokens removed');
    }
}
