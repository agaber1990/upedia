<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;


class CheckVerify
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

        return $next($request);


     }

}
