<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        if(! in_array($request->user()->type, $types)) {
            abort(403, 'You are not authorized to access this page');
        }
        return $next($request);
    }
}
