<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Menangani pemeriksaan role pengguna.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        // Pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil role pengguna yang sedang login
        $userRole = auth()->user()->role;

        // Periksa apakah role pengguna diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}