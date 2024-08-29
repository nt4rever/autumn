<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ApiLoginRequest extends LoginRequest
{
    protected $clientType = 'user';

    /**
     * Attempt to authenticate the request's credentials with OAuth password grant type.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function oauthAuthenticate()
    {
        $this->ensureIsNotRateLimited();

        $response = $this->issueTokens($this->string('email'), $this->string('password'));

        if ($response->failed()) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        return $response->json();
    }

    public function issueTokens(string $username, string $password, $scope = '*'): Response
    {
        $response = Http::asForm()->post(env('APP_URL').'/oauth/token', [
            'grant_type' => 'password',
            'client_id' => config("oauth.$this->clientType.client_id"),
            'client_secret' => config("oauth.$this->clientType.client_secret"),
            'username' => $username,
            'password' => $password,
            'scope' => $scope,
        ]);

        return $response;
    }
}
