<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    const DEV = 1;
    const ADMIN = 2;
    const USER = 3;
    public function authenticate($middlewareRoleId)
    {
        if (!Auth::check() || Auth::user()->role_id > $middlewareRoleId) {
            abort(403);
        }
    }
}
