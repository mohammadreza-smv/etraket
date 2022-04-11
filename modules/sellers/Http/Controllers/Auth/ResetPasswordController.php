<?php


namespace Modules\sellers\Http\Controllers\Auth;


use App\Lib\Mobile_Detect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends \App\Http\Controllers\Auth\ResetPasswordController
{
    protected $redirectTo = '/sellers/login';


    public function reset(Request $request)
    {
        config()->set('auth.passwords.users.provider','seller_provider');
        return parent::reset($request);
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
