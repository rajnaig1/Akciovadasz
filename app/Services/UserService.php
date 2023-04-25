<?php

namespace App\Services;

use App\Http\Middleware\AuthHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserService
{
    public function validateLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        return $validator;
    }
    public function login($validator)
    {
        $credentials = $validator->validate();
        if (Auth::attempt($credentials)) {
            return Auth::user();
        } else {
            return null;
        }
    }
    public function createToken($user)
    {
        return $user->createToken('API token:')->plainTextToken;
    }
    public function validateRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);
        return $validator;
    }
    public function register($validator)
    {
        $newUser = $validator->validate();
        $newUser['role_id'] = AuthHelper::USER;
        $user = User::create($newUser);
        auth()->login($user);
    }
    public function validateProfileModify(Request $request)
    {
        $rulesArray = [];
        if ($request->input('name') != Auth::user()->name) {
            $rulesArray['name'] = 'required|unique:users,name';
        }
        if ($request->input('email') != Auth::user()->email) {
            $rulesArray['email'] = 'required|email:rfc,dns|unique:users,email';
        }
        $rulesArray['password'] = 'required|min:8';
        $rulesArray['password_confirmation'] = 'required|same:password';
        $validator = Validator::make($request->all(), $rulesArray);
        return $validator;
    }
    public function passwordChecker($password)
    {
        if (password_verify($password, Auth::user()->password)) {
            return false;
        } else {
            return true;
        }
    }
    public function logoutAPI()
    {
        $user = Auth::user();
        $user->tokens()->delete();
    }
    public function profileModify(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();
    }
}
