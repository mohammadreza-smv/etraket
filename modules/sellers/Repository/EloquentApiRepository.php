<?php


namespace Modules\sellers\Repository;


use App\Lib\Jdf;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Modules\orders\Models\OrderProducts;
use Modules\sellers\Models\Payment;
use Modules\sellers\Models\Seller;
use Auth;
class EloquentApiRepository implements ApiRepositoryInterface
{
    public function first_step_register($request){
        $mobile=$request->get('mobile');
        $password=$request->get('password');
        $email=$request->get('email');

        settype($mobile,'integer');
        $mobile='0'.$mobile;

        if($this->check('mobile',$mobile))
        {
            return ['status'=>'error','message'=>'شماره موبایل وارد شده قبلا توسط کاربر دیگری استفاده شده'];
        }

        else if(self::check('email',$email))
        {
            return ['status'=>'error','message'=>'ایمیل وارد شده قبلا توسط کاربر دیگری استفاده شده'];
        }

        else if(!validateMobileNumber($mobile)){
            return ['status'=>'error','message'=>'شماره موبایل وارد شده معتبر نمی باشد'];
        }

        \DB::table('sellers')->where(['mobile'=>$mobile])->orWhere(['email'=>$email])->delete();

        $active_code=rand(99999,1000000);

        $seller=new Seller($request->all());
        $seller->active_code=$active_code;
        $seller->password=Hash::make($password);
        $seller->step=1;
        $seller->mobile=$mobile;
        $seller->save();

        return ['status'=>'ok','step'=>2,'mobile'=>$mobile];
    }

    protected function check($field_name,$value)
    {
        $result=Seller::where([$field_name=>$value,'step'=>4])->first();
        if($result)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function second_step_register($request)
    {
        $mobile=$request->get('mobile');
        settype($mobile,'integer');
        $mobile='0'.$mobile;

        $seller=Seller::where(['mobile'=>$mobile,'step'=>1,'account_status'=>'awaiting_approval'])->first();
        if($seller)
        {
            $data=$request->all();
            unset($data['mobile']);
            $seller->step=2;
            $seller->update($data);
            send_sms_to_seller($seller,$mobile,$seller->active_code,'sellers-active_template');
            $account_type=$request->get('account_type');
            return ['status'=>'ok','step'=>3,'mobile'=>$mobile,'account_type'=>$account_type];
        }
        else{
            return ['status'=>'error','message'=>'خطا در ثبت اطلاعات - مجددا تلاش نمایید'];
        }
    }

    public function resend_active_code($request){

        $mobile=$request->get('mobile');
        settype($mobile,'integer');
        $mobile='0'.$mobile;
        $forget_password=$request->get('forget_password','no');
        $response=['status'=>'error','message'=>'خطا در ثبت اطلاعات - مجددا تلاش نمایید'];
        if($forget_password==='ok'){
            $seller=Seller::where(['mobile'=>$mobile])->first();
            if($seller){
                $forget_password_code=rand(99999,1000000);
                $seller->forget_password_code=$forget_password_code;
                $seller->update();
                send_sms_to_seller($seller,$mobile,$forget_password_code,'sellers-active-template');

                return ['status'=>'ok'];
            }
        }
        else{
            $seller=Seller::where(['mobile'=>$mobile,'step'=>2])->whereNotNull('active_code')->first();
            if($seller){
                $data=$request->all();
                unset($data['mobile']);
                $active_code=rand(99999,1000000);
                $seller->active_code=$active_code;
                $seller->update($data);

                send_sms_to_seller($seller,$mobile,$active_code,'sellers-active-template');

                return ['status'=>'ok'];
            }
        }

        return $response;

    }

    public function check_active_code($request){
        $mobile=$request->get('mobile');
        $code=$request->get('code');
        settype($mobile,'integer');
        $mobile='0'.$mobile;

        $seller=Seller::where(['mobile'=>$mobile,'step'=>2,'active_code'=>$code])->first();
        if($seller)
        {
            $seller->step=3;
            $seller->active_code ='';
            $seller->update();
            return ['status'=>'ok'];
        }
        else
        {
            return ['status'=>'error','message'=>'کد تایید وارد شده اشتباه می باشد'];
        }
    }

    public function upload_document($request){

        $image_url3=true;
        $mobile=$request->get('mobile');
        $account_type=$request->get('account_type');
        settype($mobile,'integer');
        $mobile='0'.$mobile;

        $seller=Seller::where(['mobile'=>$mobile,'step'=>3,'account_type'=>$account_type])->first();
        if($seller)
        {
            $rules=[
                'shenasname'=>'required|image',
                'cart'=>'required|image'
            ];
            if($account_type==2)
            {
                $image_url3=false;
                $rules['rooznamepic']='required|image';
            }
            $validator=\Validator::make($request->all(),$rules);
            if($validator->fails()){
                return ['status'=>'error_file_type'];
            }
            else{
                $image_url1=upload_file($request,'shenasname','seller','shenasname_');
                $image_url2=upload_file($request,'cart','seller','cart_');
                if(!$image_url3)
                {
                    $image_url3=upload_file($request,'rooznamepic','seller','rooznamepic_');
                }

                if($image_url1 && $image_url2 && $image_url3)
                {
                    $insert=[
                        'seller_id'=>$seller->id,
                        'shenasname'=>$image_url1,
                        'cart'=>$image_url2,
                    ];
                    if($account_type==2)
                    {
                        $insert['rooznamepic']=$image_url3;
                    }
                    \DB::table('seller_document')->insert($insert);
                    $seller->step=4;
                    $seller->update();
                    return ['status'=>'ok','step'=>5];
                }
            }
        }
        else{
            return ['status'=>'error','message'=>'اطلاعات ارسال معتبر نمی باشد'];
        }

    }

    public function monthSalesStatistics()
    {
        $seller_id=\Auth::guard('seller')->user()->id;

        $jdf=new Jdf();
        $date=$jdf->tr_num($jdf->jdate('Y/n')).'/1';
        $time=getTimestamp($date,'first');

        $y=$jdf->tr_num($jdf->jdate('Y'));
        $m=$jdf->tr_num($jdf->jdate('n'));
        $t=$jdf->tr_num($jdf->jdate('t'));

        $date_list=array();
        $price_array=array();
        $count_array=array();

        for($i=0;$i<$t;$i++){
            $j=$i+1;
            $d=$y.'-'.$m.'-'.$j;
            $date_list[$i]=$d;
        }
        $orders=\DB::table('orders__products')->where('seller_id',$seller_id)
            ->where('send_status','>=',1)
            ->where('time','>=',$time)
            ->get();
        foreach($orders as $order){
            $order_date=$jdf->tr_num($jdf->jdate('Y-n-j',$order->time));
            if(array_key_exists($order_date,$price_array)){
                $price_array[$order_date]= $price_array[$order_date]+($order->product_price2*$order->product_count);
                $count_array[$order_date]=$count_array[$order_date]+1;
            }
            else{
                $price_array[$order_date]=($order->product_price2*$order->product_count);
                $count_array[$order_date]=1;
            }
        }
        foreach($date_list as $key=>$value)
        {
            if(!array_key_exists($value,$price_array))
            {
                $price_array[$key]=0;
                $count_array[$key]=0;
            }
            else{
                $price_array[$key]=$price_array[$value];
                $count_array[$key]=$count_array[$value];
                unset($price_array[$value]);
                unset($count_array[$value]);
            }
        }
        return [
            'price_array'=>$price_array,
            'count_array'=>$count_array,
            'date_list'=>$date_list
        ];
    }

    public function orders($request)
    {
        $seller_id=Auth::guard('seller')->user()->id;
        $search_text=$request->get('title','');

        $date=$request->get('date');

        $products=OrderProducts::where('seller_id',$seller_id);

        if(!empty($date)){
            $first=getTimestamp($date,'first');
            $last=getTimestamp($date,'last');
            $products=$products->whereBetween('order_time',[$first,$last]);
        }

        if(!empty($search_text))
        {
            define('search_text',$search_text);
            $products=$products->whereHas('product',function(Builder $query){
                $query->where('title','like','%'.search_text.'%');
            })->with('product');
        }
        else{
            $products=$products->whereHas('product')->with('product');
        }

        $products=$products->orderBy('id','DESC')
            ->paginate(10);

        return $products;
    }

    public function edit_profile($request)
    {
        $seller_id=get_seller_id();

        $seller=Seller::find($seller_id);

        $data=$request->all();
        unset($data['mobile']);

        if($seller->account_status=='reject')
        {
            $seller->account_status="awaiting_approval";
        }

        if(!empty($request->get('password')))
        {
            unset($data['password']);
            $seller->password=Hash::make($request->get('password'));
        }
        else{
            unset($data['password']);
        }

        $result1=add_seller_document($request,$seller_id,'shenasname');
        $result2=add_seller_document($request,$seller_id,'cart');
        $result3=add_seller_document($request,$seller_id,'rooznamepic');

        if($result1 && $result2 && $result3){
            $seller->update($data);
            if($request->get('mobile')==$seller->mobile){
                return ['status' => 'ok', 'message'=> 'ویرایش اطلاعات با موفقیت انجام شد'];
            }
            else{
                $active_code = rand(99999, 1000000);
                $seller->active_code= $active_code;
                $seller->update();
                send_sms_to_seller($seller,$request->get('mobile'),$seller->active_code,'sellers-active-template');
                $encrypted =\Crypt::encryptString($request->get('mobile'));
                return [
                    'status' => 'active_mobile',
                    'encrypted'=> $encrypted,
                    'mobile'=>$request->get('mobile')
                ];
            }
        }
        else{
            return ['status' => 'server_error'];
        }
    }

    public function profile_active_code($request)
    {
        $encrypted=$request->get('encrypted');
        $code = $request->get('code');
        $mobile = $request->get('mobile');
        $seller_id=get_seller_id();
        try {
            $hashMobile = \Crypt::decryptString($encrypted);
            $seller=Seller::where(['id'=>$seller_id, 'active_code'=>$code])->first();
            if($seller && $mobile===$hashMobile){
                $seller->mobile=$mobile;
                $seller->active_code='';
                $seller->update();
                return [
                    'status'=>'ok',
                    'message'=>'تغییر شماره موبایل با موفقیت انجام شد',
                    'redirect_url'=>url('sellers/panel/profile')
                ];
            }
            else{
                return ['status'=>'error','message'=>'خطا در پارامتر های ارسالی'];
            }
        } catch (DecryptException $e) {
            return ['status'=>'error','message'=>'خطا در پارامتر های ارسالی'];
        }
    }

    public function seller_payment($request){

        $seller_id =get_seller_id();
        $payment=Payment::where('seller_id', $seller_id)->orderBy('id','DESC');
        $date = $request->get('date');
        if (!empty($date)) {
            $first = getTimestamp($date, 'first');
            $last = getTimestamp($date, 'last');
            $payment = $payment->whereBetween('time', [$first, $last]);
        }
        return  $payment->paginate(10);
    }

    public function order_content($id){
        $seller_id=get_seller_id();
        $product=OrderProducts::where([
            'id'=>$id,
            'seller_id'=>$seller_id
        ])
            ->whereHas('product')
            ->with(['product','param1','param2'])->firstOrFail();
        if($product->seller_read=='no'){
            $product->seller_read='ok';
            $product->update();
        }
        return $product;
    }
}
