<?php


namespace Modules\sellers\Http\Controllers;


use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Auth;
class LoginController
{
    use ThrottlesLogins;

    public function login(Request $request){
        $mobile=$request->get('mobile');
        $password=$request->get('password');

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $res=Auth::guard('seller')->attempt(['mobile'=>$mobile,'password'=>$password]);
        if ($res) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return  [
            'status'=>'error',
            'message'=>'شماره موبایل یا کلمه عبور وارد شده اشتباه می باشد'
        ];
    }

    protected function sendLockoutResponse($request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            'lockoutResponse' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return [
            'reload'=>url('sellers/panel'),
            'status'=>'ok'
        ];
    }

    protected function username(){
        return 'lockoutResponse';
    }
}
