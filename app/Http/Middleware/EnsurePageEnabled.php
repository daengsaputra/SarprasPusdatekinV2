<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePageEnabled
{
    public function handle(Request $request, Closure $next, string $pageKey): Response
    {
        $user = $request->user();

        // Super admin can always access disabled pages to manage settings.
        if ($user && $user->role === User::ROLE_SUPER_ADMIN) {
            return $next($request);
        }

        if (SiteSetting::isPageEnabled($pageKey)) {
            if ($user && !SiteSetting::isRoleAllowedForPage($user->role, $pageKey)) {
                return redirect(route('dashboard'))
                    ->with('error', 'Akses halaman ini tidak diizinkan untuk role Anda.');
            }

            return $next($request);
        }

        $target = !$user ? route('root') : route('dashboard');

        return redirect($target)->with('error', 'Halaman sedang dinonaktifkan oleh Super Admin.');
    }
}
