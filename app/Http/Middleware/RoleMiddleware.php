<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return ResponseHelper::jsonResponse(false, 'Kamu belum login', null, 401);
        }

        if ($request->user()->role !== $role) {
            return ResponseHelper::jsonResponse(false, 'forbidden, kamu tidak di izinkan akses ini', null, 403);
        }

        return $next($request);
    }
}
