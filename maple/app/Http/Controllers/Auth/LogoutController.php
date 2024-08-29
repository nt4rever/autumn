<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

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

    public function apiLogout(Request $request)
    {
        if ($request->boolean('all')) {
            $request->user()->tokens()->each(function ($token) {
                $this->revokeAccessAndRefreshTokens($token->id);
            });
        } elseif ($request->user()->token() instanceof Token) {
            $this->revokeAccessAndRefreshTokens($request->user()->token()->id);
        } else {
            Auth::guard()->logout();
        }

        return new Response('', 204);
    }

    protected function revokeAccessAndRefreshTokens($tokenId)
    {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
    }
}
