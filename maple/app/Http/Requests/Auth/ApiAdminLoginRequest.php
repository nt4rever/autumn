<?php

namespace App\Http\Requests\Auth;

class ApiAdminLoginRequest extends ApiLoginRequest
{
    protected $clientType = 'admin';
}
