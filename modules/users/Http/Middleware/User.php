<?php


namespace Modules\users\Http\Middleware;

use Closure;
use Auth;
class User
{
    public function handle($request, Closure $next){
        $request=request();
        if(($request->is('admin/*') || $request->is('admin'))){
            if($request->method()=='GET'){
                run_action('load_backend_data',[]);
            }
            return  $this->panelResponse($request,$next);
        }
        else{
            if(request()->is('user/profile/*') || request()->is('user/profile') && request()->method()=='GET'){
                run_action('load_user_panel_data',[]);
            }
            return $next($request);
        }
    }

    protected function panelResponse($request,$next){
        $role_id=Auth::user()->role_id;
        if(Auth::user()->role=='admin'){
            return $next($request);
        }
        else if($role_id>0){
            if($request->route()->getName()=="error403"){
                return $next($request);
            }
            else if($request->route()->getName()=="admin"){
                return redirect('/admin/panel');
            }
            else if($request->route()->getName()=="author_panel"){
                return $next($request);
            }
            else{
                $accessList=\Modules\users\Models\User::AccessList();
                $checkUserAccess=checkUserAccess($request->route()->getName(),$accessList);
                if($checkUserAccess){
                    return $next($request);
                }
                else{
                    if($request->method()=='GET'){
                        return redirect('/admin/403');
                    }
                    else{
                        return response([
                            'message'=>'شما دسترسی لازم برای عملیات جاری را ندارید',
                            'status'=>'error'
                        ],200, ['Charset' => 'utf-8']);
                    }
                }
            }
        }
        else{
            return redirect('/');
        }
    }
}
