<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OAuthController extends Controller
{
    public function redirect(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $request->session()->put('code_verifier', $code_verifier = Str::random(128));

        $request->session()->put('back_url', $request->back_url);

        $codeChallenge = strtr(rtrim(base64_encode(hash('sha256', $code_verifier, true)), '='), '+/', '-_');

        $query = http_build_query([
            'client_id' => config('oauth.client_id'),
            'redirect_uri' => config('oauth.client_callback'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
            // 'prompt' => '', // "none", "consent", or "login"
        ]);

        return redirect(env('APP_URL').'/oauth/authorize?'.$query);
    }

    public function callback(Request $request)
    {
        $state = $request->session()->pull('state');

        $backUrl = $request->session()->pull('back_url');

        $codeVerifier = $request->session()->pull('code_verifier');

        if ($state !== $request->state) {
            return redirect('/error');
        }

        $response = Http::asForm()->post(env('APP_URL').'/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('oauth.client_id'),
            'redirect_uri' => config('oauth.client_callback'),
            'code_verifier' => $codeVerifier,
            'code' => $request->code,
        ]);

        if ($response->failed()) {
            return redirect('/error');
        }

        $credentials = $response->json();

        return redirect()->to($backUrl ?? '/')->withCookies([
            Cookie::make('access_token', data_get($credentials, 'access_token'), 60, null, null, null, false),
            Cookie::make('refresh_token', data_get($credentials, 'refresh_token'), 60, null, null, null, false),
        ]);
    }

    public function refresh(Request $request)
    {
        return $this->issueNewTokens($request->refresh_token, 'user');
    }

    public function adminRefresh(Request $request)
    {
        return $this->issueNewTokens($request->refresh_token, 'admin');
    }

    private function issueNewTokens($refreshToken, $clientType = 'user')
    {
        $response = Http::asForm()->post(env('APP_URL').'/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config("oauth.$clientType.client_id"),
            'client_secret' => config("oauth.$clientType.client_secret"),
            'scope' => '*',
        ]);

        if ($response->failed()) {
            throw new BadRequestHttpException('Bad request.');
        }

        return $response->json();
    }
}
