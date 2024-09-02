<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(
            now()->addDays(config('oauth.access_token_expire_in'))
        );
        Passport::refreshTokensExpireIn(
            now()->addDays(config('oauth.refresh_tokens_expire_in'))
        );
        Passport::personalAccessTokensExpireIn(
            now()->addDays(config('oauth.personal_access_tokens_expire_in'))
        );

        Passport::enablePasswordGrant();

    }
}
