<?php

namespace Modules\productStatusNotification\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\products\Models\Product;
use Modules\productStatusNotification\Models\ProductStatusNotification;
use PhpParser\Node\Scalar\String_;

class ApiController extends Controller
{
    public function addNotification(Request $request):array{
        $message='خطا در اجرای درخواست مجددا تلاش نمایید';
        $status='error';
        $user=$request->user();
        $product_id=$request->get('product_id');
        $product=Product::where('id',$product_id)->first();
        if($product){
            $row=ProductStatusNotification::where(['product_id'=>$product_id,'user_id'=>$user->id])->first();
            if(!$row){
                $notification=new ProductStatusNotification($request->all());
                $notification->user_id=$user->id;
                $notification->save();
                $message='ثبت درخواست با موفقیت انجام شد';
                $status='success';
            }
        }
        return [
            'status'=>$status,
            'message'=>$message
        ];
    }

    public function remove_request(Request $request){
        $product_id=$request->get('product_id');
        $user=$request->user();
        \DB::table('product_status_notification')->where([
            'product_id'=>$product_id,
            'user_id'=>$user->id
        ])->delete();
        return 'ok';
    }
}
