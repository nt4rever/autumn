<?php

return [
    'access_token_expire_in' => (int) env('OAUTH_ACCESS_TOKEN_EXPIRE_IN', 1),
    'refresh_tokens_expire_in' => (int) env('OAUTH_REFRESH_TOKENS_EXPIRE_IN', 30),
    'personal_access_tokens_expire_in' => (int) env('OAUTH_PERSONAL_ACCESS_TOKENS_EXPIRE_IN', 180),
    'client_id' => env('OAUTH_CLIENT_ID'),
    'client_secret' => env('OAUTH_CLIENT_SECRET'),
    'client_callback' => env('OAUTH_CLIENT_CALLBACK'),

];
