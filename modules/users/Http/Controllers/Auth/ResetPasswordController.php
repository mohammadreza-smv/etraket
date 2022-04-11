<?php


namespace Modules\users\Http\Controllers\Auth;


use App\Lib\Mobile_Detect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends \App\Http\Controllers\Auth\ResetPasswordController
{
    protected $redirectTo = '/';

    protected $view='';

    public function __construct()
    {
        $this->middleware('guest');
        $detect=new Mobile_Detect();
        if($detect->isMobile() || $detect->isTablet()){
            $this->view='mobile.';
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        $layout=$this->view=='mobile.' ? 'mobile' : 'desktop';
        $margin=$this->view=='mobile.' ? '10' : '25';
        return view('users::auth.passwords.reset')->with(
            ['token' => $token, 'mobile' => $request->mobile,'layout'=>$layout,'margin'=>$margin]
        );
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'mobile' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'mobile', 'password', 'password_confirmation', 'token'
        );
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return  [
            'status'=>'error',
            'message'=>'اطلاعات ارسال شده صحیح نمی باشد'
        ];
    }

    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response),'status'=>'ok'], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }
}
