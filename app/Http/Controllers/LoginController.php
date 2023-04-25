<?php

namespace App\Http\Controllers;

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
            return back()->with('loginFailure', 'loginFailure')->withErrors($validator);
        }
        $user = $this->userService->login($validator);
        if ($user != null) {
            if ($user->role_id == AuthHelper::DEV) {
                return redirect('/dev/test');
            } else if ($user->role_id == AuthHelper::ADMIN) {
                return redirect('/admin');
            } else if ($user->role_id == AuthHelper::USER) {
                return redirect('/');
            } else {
                return back()->with('loginFailure', 'loginFailure')->withErrors('Hiba történt!');
            }
        } else {
            return back()->with('loginFailure', 'loginFailure')->withErrors('Hibás felhasználónév/jelszó!');
        }
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
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
            return back()->with('registerFailure', 'registerFailure')->withErrors($validator);
        }
        $this->userService->register($validator);
        return redirect('/')->with('registerSuccess', "Account successfully registered.");
    }
    public function profileModify(Request $request)
    {
        if ($this->userService->passwordChecker($request->input('old_password'))) {
            return back()->with('profileModifyFailure', 'profileModifyFailure')->withErrors('Hibás jelszó!');
        }
        $validator = $this->userService->validateProfileModify($request);
        if ($validator->fails()) {
            return back()->with('profileModifyFailure', 'profileModifyFailure')->withErrors($validator);
        }
        $this->userService->profileModify($request);
        return redirect('/profileModify')->with('profileModifySuccess', "Account successfully modified.");
    }
}
