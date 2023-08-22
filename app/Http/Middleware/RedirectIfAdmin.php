<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->good == 1 && Auth::user()->admin == 1) {
              if (Auth::user()->role) {
                view()->share('authUser', Auth::user());
                return $next($request);
              }
            }
        }
        return redirect('admin/auth/logout');
    }
}
