<?php

namespace App\Http\Middleware;

class Cors extends Middleware
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', '*')
            ->header('"Access-Control-Allow-Headers"', '*');
    }
}
