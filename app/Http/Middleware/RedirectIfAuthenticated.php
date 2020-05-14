<?php

namespace Grofie\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    //public function handle($request, Closure $next, $guard = null)
    // {
     //   if (Auth::guard($guard)->check()) {
        //    return redirect('/admin/dashboard');
      //  }

    //    return $next($request);
    //}

    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin' :
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.dashboard');
                }
                break;
            case 'apps' :
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('apps.account');
                }
                break;   
            case 'delivery' :
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('delivery.dashboard');
                }
                break;  
               
            default;
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('home');
                }
                break;
        }
     return $next($request);
    }

}
