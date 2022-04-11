<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'password','account_status','active_code','role','role_id','username','forget_password_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function changeMobileNumber($request)
    {
        $mobile=$request->get('mobile');
        $active_code=$request->get('active_code');
        $user_id=$request->user()->id;
        $AdditionalInfo=AdditionalInfo::where(['user_id'=>$user_id,'mobile_phone'=>$mobile])->first();
        if($AdditionalInfo)
        {
            $user=User::find($user_id);
            if($active_code==$user->active_code){
                $user->mobile=$AdditionalInfo->mobile_phone;
                $user->update();
                return redirect('user/profile/additional-info')->with('status','ثبت اطلاعات با موفقیت انجام شد');
            }
            else{
                return redirect()->back()->with('mobile_number',$mobile)->with(['validate_error'=>'کد فعال سازی وارد شد اشتباه می باشد']);
            }
        }
        else{
            return redirect('/');
        }
    }
    public static function resend($request)
    {
        $active_code=rand(99999,1000000);
        $mobile=$request->get('mobile');
        $forget_password=$request->get('forget_password','no');
        $user=null;
        $result='error';
        $forget=false;
        if($request->ajax())
        {
            if(Auth::check())
            {
                $user_id=$request->user()->id;
                $row=AdditionalInfo::where('user_id',$user_id)->first();
                $user=User::where(['id'=>$user_id])->first();
                if($row && $row->mobile_phone!=$user->mobile){
                    $user->active_code=$active_code;
                    $result='ok';
                }
            }
            else{
                if($forget_password=='ok')
                {
                    $user=User::where(['mobile'=>$mobile,'account_status'=>'active'])->first();
                    if($user)
                    {
                        $forget=true;
                        $user->forget_password_code=$active_code;
                        $result='ok';
                    }
                }
                else{
                    $user=User::where(['mobile'=>$mobile,'account_status'=>'InActive'])->first();
                    if($user)
                    {
                       $user->active_code=$active_code;
                       $result='ok';
                    }
                }
            }

            if( $result=='ok' && $user)
            {
                $user->update();
                $c= $forget ? $user->forget_password_code : $user->active_code;
                $message=env("SHOP_NAME",'')."\n";
                $message.='کد تایید';
                $message.=" : ".$c;

                $user->notify(new \App\Notifications\SendSms( $user->mobile,$message));
            }
        }
        else{
            return 'error';
        }
    }
    public static function getData($request)
    {
        $string='?';
        $users=self::with('getRole')->orderBy('id','DESC');
        if(inTrashed($request))
        {
            $users=$users->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(array_key_exists('name',$request) && !empty($request['name']))
        {
            $users=$users->where('name','like','%'.$request['string'].'%');
            $string=create_paginate_url($string,'name='.$request['name']);
        }
        if(array_key_exists('mobile',$request) && !empty($request['mobile']))
        {
            $mobile=\replace_number2($request['mobile']);
            $users=$users->where('mobile','like','%'.$mobile.'%');
            $string=create_paginate_url($string,'mobile='.$request['mobile']);
        }
        if(array_key_exists('role',$request) && !empty($request['role']))
        {
            if($request['role']=='admin' || $request['role']=='user')
            {
                $users=$users->where('role',$request['role']);
            }
            else{
                $users=$users->where(['role'=>'user','role_id'=>$request['role']]);
            }
            $string=create_paginate_url($string,'role='.$request['role']);
        }
        $users=$users->paginate(10);
        $users->withPath($string);
        return $users;
    }
    public function getRole()
    {
        return $this->hasone(UserRole::class,'id','role_id')->withTrashed();
    }
    public function getAdditionalInfo()
    {
        return $this->hasone(AdditionalInfo::class,'user_id','id')->with('getCity')->with('getProvince');
    }
    public static function AccessList(){
        $array=array();
        $array['products']=[
             'label'=>'محصولات',
             'access'=>[
                  'product_edit'=>['label'=>'ثبت و ویرایش محصولات','routes'=>[
                      'products.index','products.create','products.store','products.edit','products.update'
                  ]],
                  'remove_product'=>['label'=>'حذف محصولات','routes'=>['products.index','products.destroy']],
                  'restore_product'=>['label'=>'بازیابی محصولات','routes'=>['products.index','products.restore']]
             ]
        ];

        $array['sliders']=[
            'label'=>'اسلایدر ها',
             'access'=>[
                  'slider_edit'=>['label'=>'ثبت و ویرایش اسلایدر','routes'=>[
                      'sliders.index','sliders.create','sliders.store','sliders.edit','sliders.update'
                  ]],
                  'remove_slider'=>['label'=>'حذف اسلایدرها','routes'=>['sliders.index','sliders.destory']],
                  'restore_slider'=>['label'=>'بازیابی اسلایدرها','routes'=>['sliders.index','sliders.restore']]
             ]
        ];
        $array['orders']=[
            'label'=>'سفارشات',
            'access'=>[
                'order_list'=>['label'=>'مدیریت سفارشات','routes'=>['orders.index','orders.show']],
                'change_status'=>['label'=>'تغییر وضعیت سفارش','routes'=>['order.change_status']],
                'order.destroy'=>['label'=>'حذف سفارش','routes'=>['orders.index','orders.destroy']],
                'order.restore'=>['label'=>'بازیابی سفارش','routes'=>['orders.index','orders.restore']],
                'submissions'=>['label'=>'مدیریت مرسوله ها','routes'=>['orders.submissions','submissions_info','submissions_factor']],
                'submission_approved'=>['label'=>' مرسوله های تایید شده','routes'=>['orders.submissions_approved','submissions_info','submissions_factor']],
                'items_today'=>['label'=>'مرسوله های ارسالی امروز','routes'=>['orders.items_today','submissions_info','submissions_factor']],
                'submissions_ready'=>['label'=>'مرسوله های اماده ارسال','routes'=>['orders.submissions_ready','submissions_info','submissions_factor']],
                'postings_sent'=>['label'=>'مرسوله های ارسال شده به پست','routes'=>['orders.postings_sent','submissions_info','submissions_factor']],
                'postings_receive'=>['label'=>'مرسوله های آماده دریافت از پست','routes'=>['orders.postings_receive','submissions_info','submissions_factor']],
                'delivered_shipping'=>['label'=>'مرسوله های تحویل داده شده','routes'=>['orders.delivered_shipping','submissions_info','submissions_factor']],
                'return_product'=>['label'=>'مرجوع کردن سفارش','routes'=>['orders.index','orders.return_product_list','return-product']],
            ]
        ];
        $array['stockrooms']=[
            'label'=>'انبار',
             'access'=>[
                  'stockroom_edit'=>['label'=>'مدیریت انبار ها','routes'=>[
                      'stockrooms.index','stockrooms.show','stockrooms.create','stockrooms.store','stockrooms.edit','stockrooms.update'
                  ]],
                  'add_input'=>['label'=>'ثبت ورودی انبار','routes'=>['stockroom.input','stockroom.show_input','stockroom.add_product','stockroom.add_input','get_product_warrnty','stockroom.input_factor']],
                  'add_output'=>['label'=>'ثبت خروجی انبار','routes'=>['stockroom.output','stockroom.show_output','stockroom.show_output','stockroom.add_output','get_inventory','stockroom.output_factor']],
                  'package'=>['label'=>'مدیریت محموله ها','routes'=>['packages.index','packages.show','packages.destory','packages.restore']]
             ]
        ];
        $array['discount']=[
            'label'=>'تخفیف ها',
            'access'=>[
                'discount'=>['label'=>'مدیریت کد های تخفیف','routes'=>[
                    'discount.index','discount.edit','discount.update','discount.create','discount.store',
                    'discount.destroy','discount.restore'
                ]],
            ]
        ];
        $array['report']=[
            'label'=>'گزارشات',
            'access'=>[
                'report_sale'=>['label'=>'آمار فروش فروشگاه','routes'=>['sale_report','get_sale_report']],
                'report_view'=>['label'=>'آمار بازید','routes'=>[]],
                'commission'=>['label'=>'کمیسیون ها','routes'=>['commissions.index','commissions.edit','commissions.update','commissions.create','commissions.store',
                    'commissions.destroy','commissions.restore']],
                'payment'=>['label'=>'پرداخت ها','routes'=>['payments']],
            ]
        ];
        $array['files']=[
            'label'=>'مدیریت فایل ها',
            'access'=>[
                'files'=>['label'=>'امکان آپلود و حذف فایل ها','routes'=>['filemanager']],
            ]
        ];
        $array['users']=[
            'label'=>'کاربران',
            'access'=>[
                'user_edit'=>['label'=>'ثبت و ویرایش کاربر','routes'=>['users.index','users.create','users.store','users.edit','users.update']],
                'user_remove'=>['label'=>'حذف کاربر','routes'=>['users.index','users.destroy']],
                'user_restore'=>['label'=>'بازیابی کاربر','routes'=>['users.index','users.restore']],
                'user_order'=>['label'=>'نمایش سفارشات کاربر','routes'=>['users.index','users.show']],
                'user_access'=>['label'=>'مدیریت نقش های کاربری','routes'=>['userRole.index','userRole.create','userRole.store','userRole.edit','userRole.update','userRole.destroy','userRole.restore','userRole.access','userRole.add_access']],
                'user_message'=>['label'=>'مدیریت پیام ها','routes'=>[
                    'users.index','user.message.index','user.message.show','user.message.create','user.message.store','user.message.answer'
                ]],
            ]
        ];
        $array['pages']=[
            'label'=>'صفحات اضافی',
            'access'=>[
                'page_edit'=>['label'=>'ثبت و ویرایش صفحات','routes'=>['pages.index','pages.create','pages.store','pages.edit','pages.update']],
                'page_delete'=>['label'=>'حذف صفحات','routes'=>['pages.index','pages.destroy']],
                'page_restore'=>['label'=>'بازیابی صفحات','routes'=>['pages.index','pages.restore']],
            ]
        ];
        $array['seller']=[
            'label'=>'فروشندگان',
            'access'=>[
                'seller.manager'=>['label'=>'مدیریت فروشندگان','routes'=>['sellers.index','sellers.edit','sellers.update','sellers.show']],
                'seller_delete'=>['label'=>'حذف اطلاعات فروشنده','routes'=>['sellers.index','sellers.destroy']],
                'seller_restore'=>['label'=>'بازیابی اطلاعات فروشنده','routes'=>['sellers.index','sellers.restore']],
                'seller_message'=>['label'=>'مدیریت پیام ها','routes'=>['sellers.index',
                    'seller.message.index','seller.message.show','seller.message.create','seller.message.store','seller.message.answer'
                ]],
            ]
        ];
        $array['questions']=[
            'label'=>'پرسش ها و پاسخ های کاربران ',
            'access'=>[
                'question_manager'=>['label'=>'مدیریت پرسش ها و پاسخ های کاربران ',
                 'routes'=>['questions.index','change_question_status','questions.destroy','questions.restore','questions_addAnswer']],
            ]
        ];
        $array['comments']=[
            'label'=>'نظرات کاربران',
            'access'=>[
                'comment_manager'=>['label'=>'مدیریت نظرات کاربران',
                    'routes'=>['comments.index','comment_change_status','comments.destroy','comments.restore']],
            ]
        ];
        $array['incredible-offers']=[
            'label'=>'پیشنهاد شگفت انگیز',
            'access'=>[
               'incredible_offers_manager'=>['label'=>'مدیریت محصولات شگفت انگیز','routes'=>[
                    'incredible_offers','ajaxGetWarranty',
                    'add_incredible_offers','remove_incredible_offers'
                ]],
            ]
        ];
        return $array;
    }
    public function getEmailForPasswordReset()
    {
        return $this->mobile;
    }
    public function findForPassport($mobile)
    {
        return $this->where(['mobile'=>$mobile,'account_status'=>'active'])->first();
    }
}
