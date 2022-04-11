<?php


namespace Modules\sellers\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('seller')->check()) {

            if($request->route()->uri==='sellers/login'){
                return redirect('/sellers/panel');
            }
            else{
                return redirect('/sellers/login');
            }

        }

        return $next($request);
    }
}
