<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SsoController;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Logout pengguna; deferred ke SsoController agar kalau SSO_DOMAIN
     * dikonfigurasi, sekaligus logout dari SSO BPIP.
     */
    public function logout(Request $request)
    {
        return app(SsoController::class)->logout($request);
    }
}
