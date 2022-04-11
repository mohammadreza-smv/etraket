<?php

namespace Modules\users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\users\Http\Requests\AdditionalRequest;
use Modules\users\Repository\AdditionalInfoRepositoryInterface;

class UserPanelController extends Controller
{
    public function profile(){
        return CView('users::user-panel.'.$this->view.'profile');
    }

    public function additional_info(AdditionalInfoRepositoryInterface $repository,Request $request){
        if(view_type=='mobile'){

            $repository=app(AdditionalInfoRepositoryInterface::class);
            $additionalInfo=$repository->first(request());
            $personal_user_detail=personal_user_detail($additionalInfo);

            return CView('users::user-panel.'.$this->view.'.additional-info',compact(
                'additionalInfo','personal_user_detail'
            ));
        }
        else{
            return  redirect('profile');
        }
    }

    public function save_additional_info(AdditionalRequest $request,AdditionalInfoRepositoryInterface $additionalInfoRepository){
        $user=$request->user();
        return $additionalInfoRepository->addUserInfo($user,$request);
    }

    public function confirmMobile(){
        if(\Session::has('mobile_number')){
            $layout=$this->view=='mobile.' ? 'mobile' : 'desktop';
            $margin=$this->view=='mobile.' ? '10' : '25';
            return view('users::auth.confirm-mobile',['layout'=>$layout,'margin'=>$margin]);
        }
        else{
            return redirect('/');
        }
    }

    public function changeMobileNumber(Request $request, AdditionalInfoRepositoryInterface $additionalInfoRepository)
    {
        $mobile=$request->get('mobile');
        $active_code=$request->get('active_code');
        $user_id=$request->user()->id;
        $additionalInfo=$additionalInfoRepository->find([
            'user_id'=>$user_id,
            'mobile_phone'=>$mobile
        ]);
        $result='خطا در ارسال اطلاعات،مجددا تلاش نمایدد';
        if($additionalInfo){
            $user=$request->user();
            if($user->active_code==$active_code){
                $user->active_code=null;
                $user->mobile=$mobile;
                $user->update();
                $result='ok';
            }
            else{
                $result='کد فعال سازی اشتباه میباشد';
            }
        }
        return  $result;
    }
}
