<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ApiAdminLoginRequest;
use App\Http\Requests\Auth\ApiLoginRequest;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function view()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function apiLogin(ApiLoginRequest $request)
    {
        $response = $request->oauthAuthenticate();

        return $response;
    }

    public function apiAdminLogin(ApiAdminLoginRequest $request)
    {
        $response = $request->oauthAuthenticate();

        return $response;
    }
}
