<?php

namespace Modules\users\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\setting\Repository\SettingRepositoryInterface;
use Modules\users\Http\Requests\UserRequest;
use Modules\users\Repository\UserRoleRepositoryInterface;
use Modules\users\Repository\UsersRepositoryInterface;

class UsersController extends CustomController
{
    protected $title='کاربر';

    protected $route_params='users';

    protected $repository;

    public function __construct(UsersRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request,UserRoleRepositoryInterface $roleRepository)
    {
        $users=$this->repository->getList($request);

        $trash_user_count=$this->repository->trashCount();

        $roles=$roles=['admin'=>'مدیر','user'=>'کاربر عادی']+$roleRepository->all();

        return CView('users::panel.index',[
            'users'=>$users,
            'trash_user_count'=>$trash_user_count,
            'req'=>$request,
            'roles'=>$roles
        ]);
    }

    public function create(UserRoleRepositoryInterface $roleRepository)
    {
        $roles=$roles=['admin'=>'مدیر','user'=>'کاربر عادی']+$roleRepository->all();
        return CView('users::panel.create',['roles'=>$roles]);
    }

    public function store(UserRequest $request)
    {
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/users'),
            'message'=>'ثبت کاربر جدید با موفقیت انجام شد'
        ];
    }

    public function edit($id,UserRoleRepositoryInterface $roleRepository)
    {
        $user=$this->repository->find($id);
        $roles=$roles=['admin'=>'مدیر','user'=>'کاربر عادی']+$roleRepository->all();
        return CView('users::panel.edit',['roles'=>$roles,'user'=>$user]);
    }

    public function update($id,UserRequest $request)
    {
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/users'),
            'message'=>'ویرایش اطلاعات کاربر با موفقیت انجام شد'
        ];
    }

    public function show($id)
    {
//        $user=User::with(['getRole','getAdditionalInfo'])->findOrFail($id);
//        $orders=Order::where('user_id',$id)->orderBy('id','DESC')->limit(10)->get();
//        $comments=Comment::with(['getProduct','getUserInfo','getScore'])->whereHas('getScore')
//        ->orderBy('id','DESC')->where('user_id',$id)->limit(10)->get();
//        $questions=Question::where(['user_id'=>$id,'question_id'=>0])->limit(10)->get();
//        return view('users.show',[
//            'user'=>$user,
//            'orders'=>$orders,
//            'comments'=>$comments,
//            'questions'=>$questions,
//        ]);
    }

    public function sms_setting(Request $request,SettingRepositoryInterface $settingRepository){
        if($request->isMethod('post')){
           $settingRepository->set_data($request->all());
            return  [
                'redirect_url'=>url('admin/user/sms/channel'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        else{
            $data=$settingRepository->get_data([
                'users-channel',
                'users-line_number',
                'users-api-key',
                'users-active_template'
            ]);
        }
        $channels=run_action('sms_channel_info',[],true);

        $channelList=array();
        foreach ($channels as $channel){
            $channelList[$channel['name']]=$channel['title'];
        }
        return CView('users::panel.sms_setting',compact('channelList','data'));
    }
}
