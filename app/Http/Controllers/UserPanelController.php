<?php

namespace App\Http\Controllers;

use App\AdditionalInfo;
use App\City;
use App\Comment;
use App\GiftCart;
use App\Http\Requests\AdditionalRequest;
use App\Order;
use App\OrderData;
use App\Province;
use Illuminate\Http\Request;
use Auth;
class UserPanelController extends FrontController
{
    public function gift_cart(Request $request){

        $user_id=$request->user()->id;
        $gift_carts=GiftCart::where('user_id',$user_id)->orderBy('id','DESC')->paginate(10);
        return view($this->view.'userPanel.gift_cart',['gift_carts'=>$gift_carts]);
    }
    public function save_additional_info(AdditionalRequest $request){
        $user_id=$request->user()->id;
        $user=\App\User::findOrFail($user_id);
        return AdditionalInfo::addUserData($user,$request);
    }
    public function personal_info(){
        if($this->view=='mobile.')
        {
            $user=Auth::user()->id;
            $additionalInfo=AdditionalInfo::where(['user_id'=>$user])->first();
            return view($this->view.'userPanel.personal-info',['additionalInfo'=>$additionalInfo]);
        }
        else{
            return redirect('/user/profile');
        }
    }

}
