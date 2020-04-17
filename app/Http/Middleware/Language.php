<?php

namespace App\Http\Middleware;

use Closure;

class Language
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
         if(\Setting::get('default_lang')) {
            \App::setLocale(\Setting::get('default_lang'));
        }
        return $next($request);
    }
}
