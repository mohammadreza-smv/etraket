<?php


namespace Modules\users\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\users\Models\User;
use Modules\users\Repository\AdditionalInfoRepositoryInterface;
use Modules\users\Repository\UsersRepositoryInterface;
use Auth;

class ApiController extends Controller
{
    public function register(Request $request){
        $mobile=$request->get('mobile');
        $password=$request->get('password');
        $name=$request->get('name');
        $identifier_code=$request->get('identifier_code');
        $user=User::where('mobile',$mobile)->first();
        if($user){
            if($user->account_status=='InActive'){
                $user->forceDelete();
                userRegister($name,$mobile,$password,$identifier_code);
                return ['status'=>'ok'];
            }
            else{
                return ['error'=>'شماره موبایل وارد شده تکراری می باشد','status'=>'error'];
            }
        }
        else{
            userRegister($name,$mobile,$password,$identifier_code);
            return ['status'=>'ok'];
        }
    }

    public function check_active_code(Request $request){
        $mobile=$request->get('mobile');
        $code=$request->get('code');
        $user=User::where(['mobile'=>$mobile,'account_status'=>'InActive','active_code'=>$code])->first();
        if($user){
            $user->active_code=null;
            $user->account_status='active';
            $user->update();
            return  'ok';
        }
        else{
            return 'error';
        }
    }

    public function resend_active_code(Request $request){
        $mobile=$request->get('mobile');
        $user=User::where(['mobile'=>$mobile,'account_status'=>'InActive'])->first();
        if($user){
            $active_code=rand(99999,1000000);
            $user->active_code=$active_code;
            $user->update();
            send_auth_sms($user,$active_code,$mobile);
            return  'ok';
        }
        else{
            return 'error';
        }
    }

    public function user_global_detail(Request $request){
        $user=$request->user();
        return [
            'name'=>$user->name,
            'mobile'=>$user->mobile
        ];
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return 'ok';
    }

    public function add_register_detail(Request $request,UsersRepositoryInterface $usersRepository){

        $user=$request->user();
        $usersRepository->add_register_detail($user,$request->all());
        return 'ok';
    }

    public function update_mobile(Request $request,AdditionalInfoRepositoryInterface $repository){
        $user=$request->user();
        $mobile=$request->get('mobile');
        $value=$mobile;
        settype($value,'integer');
        if($user->mobile==$mobile)
        {
            return 'شماره موبایل قبلا توسط شما ثبت شده';
        }
        else if(strlen($value)==10 && is_numeric($value) && substr($value,0,1)=="9")
        {
            $check=User::whereIn('mobile',[$value,"0".$value])->first();
            if($check && $check->id!=$user->id){
                return 'شماره موبایل توسط شخص دیگری ثبت شده';
            }
            else{
                $repository->update_mobile($request);
                return 'ok';
            }
        }
        else{
            return  'شماره موبایل وارد شده اشتباه میباشد';
        }
    }

    public function resend(Request $request,UsersRepositoryInterface $userRepository)
    {
        $result='error';
        $code=rand(99999,1000000);
        $user=null;
        $forget_password=$request->get('forget_password','no');
        $mobile=$request->get('mobile');
        if(!Auth::check()){
            $user=$userRepository->first(['mobile'=>$mobile]);
            if($user){
                if($user->account_status=='InActive'){
                    $user->active_code=$code;
                    $result='ok';
                }
                else if($user->account_status=='active' && $forget_password){
                    $user->forget_password_code=$code;
                    $result='ok';
                }
            }
        }
        else{
            $user=$request->user();
            if($user->mobile !=$mobile){
                $user->active_code=$code;
                $result='ok';
            }
        }

        if($result=='ok'){
            $user->update();
            send_auth_sms($user,$code);
        }

        return $result;
    }

    public function update_bankCard(Request $request,UsersRepositoryInterface $repository){
        $user=$request->user();
        $code=$request->get('bank_card_number');
        if(empty($code) || !validateBankCard($code))
        {
            return 'شماره کارت وارد شده صحیح نمی باشد';
        }
        else{
            $repository->add_register_detail($user,$request->all());
            return 'ok';
        }
    }

    public function update_national_identity_number(Request $request,UsersRepositoryInterface $repository){
        $user=$request->user();
        $code=$request->get('national_identity_number');
        $code=replace_number2($code);
        if(empty($code) || !validateNationalIdentityNumber($code))
        {
            return 'کد ملی وارد شده صحیح نمی باشد';
        }
        else{
            $repository->add_register_detail($user,$request->all());
            return 'ok';
        }
    }

    public function email_number(Request $request,UsersRepositoryInterface $repository){
        $user=$request->user();
        $code=$request->get('email');
        $code=replace_number2($code);
        if(empty($code))
        {
            return 'ایمیل نمی تواند خالی باشد';
        }
        else{
            $repository->add_register_detail($user,$request->all());
            return 'ok';
        }
    }

    public function updateDateOfBirth(Request  $request,UsersRepositoryInterface $userRepository){
        $user=$request->user();
        $date_of_birth=$request->get('date_of_birth');
        if(empty($date_of_birth) || !validateData($date_of_birth)){
            return 'تاریخ تولد وارد شده صحیح نمی باشد';
        }
        else{
            $userRepository->add_register_detail($user,$request->all());
            return  'ok';
        }
    }
}
