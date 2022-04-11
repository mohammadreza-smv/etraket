<?php

namespace Modules\sellers\Http\Middleware;

use Closure;

class CheckSellerAccount
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
        $seller=\Auth::guard('seller')->user();
        if($seller->account_status=='active')
        {
            return $next($request);
        }
        else{

            if (! $request->expectsJson()) {
                return redirect('sellers/panel');
            }
            else{
                return response([
                    'reload'=>url('sellers/panel')
                ],302,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
            }
        }
    }
}
