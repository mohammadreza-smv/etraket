<?php


namespace Modules\users\Http\Controllers\Auth;


use App\Lib\Mobile_Detect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use URL;
use Lang;
class LoginController extends \App\Http\Controllers\Auth\LoginController
{
    protected $view='';

    public function __construct()
    {
        parent::__construct();
        $detect=new Mobile_Detect();
        if($detect->isMobile() || $detect->isTablet()){
            $this->view='mobile.';
        }
    }

    public function showLoginForm()
    {
        $layout=$this->view=='mobile.' ? 'mobile' : 'desktop';
        return CView('users::auth.login',['layout'=>$layout]);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],[],[
            'mobile'=>'شماره موبایل',
            'username'=>'نام کاربری',
            'password'=>'کلمه عبور'
        ]);
    }

    protected function credentials(Request $request)
    {
        $credentials=$request->only($this->username(), 'password');
        $credentials['account_status']='active';
        $url=URL::previous();
        if($url==url('admin_login'))
        {
            $credentials['role']='admin';
        }
        else{
            $credentials['role']='user';
        }
        return  $credentials;
    }

    public function username()
    {
        $url=URL::previous();
        if($url==url('login'))
        {
            return 'mobile';
        }
        else{
            return  'username';
        }
    }

    protected function authenticated(Request $request, $user)
    {
        run_action('authenticated',[$user]);
    }

    public function login(Request $request)
    {
        if($request->header('X-Xsrf-Token',NULL)){
            if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request))
            {
                $this->fireLockoutEvent($request);
                $seconds = $this->limiter()->availableIn(
                    $this->throttleKey($request)
                );

                $message=Lang::get('auth.throttle', ['seconds' => $seconds]);
                return ['status'=>$message];
            }
            if ($this->attemptLogin($request)) {
                $request->session()->regenerate();
                $this->authenticated($request, $this->guard()->user());
                $this->clearLoginAttempts($request);
                return ['status'=>'ok'];
            }
            else{
                $this->incrementLoginAttempts($request);
                return ['status'=>'شماره موبایل یا کلمه عبور وارد شده اشتباه می باشد'];
            }
        }
    }

    public function admin_login_form(){
        $layout=$this->view=='mobile.' ? 'mobile' : 'desktop';
        return CView('users::auth.admin_login_form',['layout'=>$layout]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return  [
            'reload'=>url('')
        ];
    }
}
