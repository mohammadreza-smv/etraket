<?php


namespace Modules\sellers\Http\Controllers\Auth;


use App\Lib\Mobile_Detect;
use Illuminate\Http\Request;
use Modules\sellers\Models\Seller;
use Modules\users\Models\User;
use Session;
class ForgotPasswordController extends \App\Http\Controllers\Auth\ForgotPasswordController
{
    public function showLinkRequestForm()
    {
        view()->share('page_title','بازیابی کلمه عبور| بخش فروشندگان');
        return CView('sellers::auth.passwords.mobile');
    }

    protected function credentials(Request $request)
    {
        return $request->only('mobile');
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['mobile' => 'required']);
    }

    public function sendResetLinkEmail(Request $request)
    {
        config()->set('auth.passwords.users.provider','seller_provider');

        $this->validateEmail($request);

        $seller=$this->broker()->getUser($this->credentials($request));

        if($seller)
        {
            $token=$this->broker()->createToken($seller);
            $forget_password_code=rand(99999,1000000);
            $seller->forget_password_code=$forget_password_code;
            Session::put('forget_password_token',$token);
            $seller->update();

            send_sms_to_seller($seller,
                $seller->mobile,
                $seller->forget_password_code,
                'sellers-active-template');

            return  [
                'status'=>'ok',
            ];
        }
        else{
            return  [
                'status'=>'error',
                'message'=>'شماره موبایل وارد شده اشتباه می باشد'
            ];
        }

    }

    public function check_confirm_code(Request $request)
    {
        $mobile=$request->get('mobile');
        $token=Session::get('forget_password_token');
        $forget_password_code=$request->get('forget_password_code');
        $seller=Seller::where(['forget_password_code'=>$forget_password_code,'mobile'=>$mobile])->first();
        if($seller)
        {
            $seller->forget_password_code=null;
            $seller->update();
            Session::forget('token');
            return [
                'status'=>'ok',
                'token'=>$token
            ];
        }
        else{
            return [
                'status'=>'error',
                'message'=>'کد وارد شده اشتباه میباشد'
            ];
        }
    }

}
