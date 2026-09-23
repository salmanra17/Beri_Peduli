<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_active === false) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $loginRoute = $request->is('admin*') ? 'admin.login' : 'login';

            return redirect()->route($loginRoute)->withErrors('Akun Anda telah dinonaktifkan oleh admin.');
        }

        return $next($request);
    }
}
