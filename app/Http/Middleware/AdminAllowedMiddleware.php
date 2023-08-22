<?php

namespace App\Http\Middleware;

use Closure;

class AdminAllowedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.env') === 'production') {
            if (config('avl.allowedIp')) {
                if (!in_array($request->ip(), config('avl.allowedIp'))) {
                    return abort(404);
                }
            }
        }
        return $next($request);
    }
}
