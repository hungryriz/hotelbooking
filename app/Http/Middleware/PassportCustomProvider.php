<?php

namespace App\Http\Middleware;

use Config;
use Closure;

class PassportCustomProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->all();
        if (array_key_exists('guard', $params)) {
            Config::set('auth.guards.api.provider', $params['guard']);
        }
        return $next($request);
    }
}
