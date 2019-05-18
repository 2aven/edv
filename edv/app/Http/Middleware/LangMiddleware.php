<?php

namespace App\Http\Middleware;

use Closure;

class LangMiddleware
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
        // Obtain lang subdomain
        $url_array = explode('.', parse_url($request->url(), PHP_URL_HOST));
        $subdomain = $url_array[0];
    
        $languages = \Config::get('app.locales');
        if (array_key_exists($subdomain,\Config::get('app.locales')))
          \App::setLocale($subdomain);
    
        return $next($request);
    }
}