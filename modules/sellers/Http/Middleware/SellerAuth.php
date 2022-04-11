<?php


namespace Modules\sellers\Http\Middleware;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Support\Facades\Date;

class SellerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('seller')->check()) {
            $seller=\Auth::guard('seller')->user();
            $seller->updated_at=Date::now();
            $seller->update();
            return $next($request);
        }
        else{
            if (! $request->expectsJson()) {
                return redirect('sellers/login');
            }
            else{
                return response([
                   'reload'=>url('sellers/login')
                ],302,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
            }

        }
    }
}
