<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $tokenCookies = [
            \Cookie::forget('access_token'),
            \Cookie::forget('refresh_token'),
        ];

        return redirect()->intended($request->back_url ?? '/')->withCookies($tokenCookies);
    }
}
