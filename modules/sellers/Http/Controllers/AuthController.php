<?php


namespace Modules\sellers\Http\Controllers;


use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register_form(){
        config()->set('view.build_component','add');
        view()->share('page_title','ثبت نام فروشندگان');
        return CView('sellers::auth.register_form');
    }

    public function login_form(){
        config()->set('view.build_component','add');
        view()->share('page_title','ورود به پنل فروشندگان');
        return CView('sellers::auth.login_form');
    }

}
