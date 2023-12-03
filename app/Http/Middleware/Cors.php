<?php

namespace App\Http\Middleware;

class EncryptCookies extends Middleware
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, 
            OPTIONS')
            ->header('"Access-Control-Allow-Headers"', '*');
    }
}
