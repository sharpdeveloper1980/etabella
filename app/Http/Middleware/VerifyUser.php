<?php

namespace App\Http\Middleware;

use Closure;

class VerifyUser
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
        if($request->session()->has('type'))
        {
            if($request->session()->get("type")=="admin")
            {
                return redirect('/home');
            }
        }
        if($request->session()->has('type'))
        {
            if($request->session()->get('type')=="client")
            {
              return redirect('/clients/login');
            }
        }
        return $next($request);
    }
}
