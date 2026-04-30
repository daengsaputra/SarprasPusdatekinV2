<?php

return [
    /*
    |--------------------------------------------------------------------------
    | BPIP SSO (OAuth2) Configuration
    |--------------------------------------------------------------------------
    | Mirror konfigurasi sinergi. Isi nilai-nilai berikut di .env:
    |   SSO_CLIENT_ID, SSO_CLIENT_SECRET, SSO_REDIRECT_URI,
    |   SSO_AUTHORIZATION_URL, SSO_ACCESS_TOKEN_URL,
    |   SSO_RESOURCE_OWNER_DETAILS_URL,
    |   SSO_DOMAIN (untuk SSO logout endpoint),
    |   URL_API_BPIP (untuk endpoint /auth/detail).
    */

    'enabled' => env('SSO_ENABLED', true),

    'client_id'                  => env('SSO_CLIENT_ID'),
    'client_secret'              => env('SSO_CLIENT_SECRET'),
    'redirect_uri'               => env('SSO_REDIRECT_URI'),
    'authorization_url'          => env('SSO_AUTHORIZATION_URL'),
    'access_token_url'           => env('SSO_ACCESS_TOKEN_URL'),
    'resource_owner_details_url' => env('SSO_RESOURCE_OWNER_DETAILS_URL'),

    'sso_domain'                 => env('SSO_DOMAIN', ''),
    'api_bpip_url'               => env('URL_API_BPIP', ''),
    'api_siatap_url'             => env('URL_API_SIATAP_BPIP', ''),

    /*
    | Default role bagi user yang berhasil login via SSO tetapi tidak ada di
    | tabel sso_role_overrides. Disesuaikan agar pegawai biasa hanya punya
    | akses peminjam.
    */
    'default_role' => env('SSO_DEFAULT_ROLE', \App\Models\User::ROLE_PEMINJAM),
];
