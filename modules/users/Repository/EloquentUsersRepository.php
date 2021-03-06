<?php


namespace Modules\users\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\users\Models\AdditionalInfo;
use Modules\users\Models\User;
use Hash;
class EloquentUsersRepository extends EloquentBaseRepository implements UsersRepositoryInterface
{
    protected $model='Modules\users\Models\User';

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function create($request)
    {
        $user=new User($request->all());
        if($request->get('role')=="admin" || $request->get('role')=="user")
        {
            $user->role=$request->get('role');
        }
        else{
            $user->role="user";
            $user->role_id=$request->get('role');
        }
        $user->password= Hash::make($request->get('password'));
        $user->saveOrFail();
    }

    public function trashCount()
    {
        return User::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return User::getData($request->all());
    }

    public function update($id, $request)
    {
        $data=$request->all();
        $user=User::findOrFail($id);
        if($request->get('role')=="admin" || $request->get('role')=="user")
        {
            $data['role']=$request->get('role');
        }
        else{
            $data['role']="user";
            $data['role_id']=$request->get('role');
        }
        if(!empty($request->get('password')))
        {
            $data['password']= Hash::make($request->get('password'));
        }
        else{
            unset($data['password']);
        }
        $user->update($data);
    }

    public function first($where)
    {
        return User::where($where)->first();
    }

    public function get_user_register_detail($user_id)
    {
        return AdditionalInfo::where('user_id',$user_id)->first();
    }

    public function add_register_detail($user, $data)
    {
        $data['mobile_phone']=$user->mobile;
        $user_id=$user->id;
        $detail = AdditionalInfo::updateOrCreate(
            ['user_id' =>$user_id],
            $data
        );
        if(array_key_exists('first_name',$data)){
            $name=$detail->first_name.' '.$detail->last_name;
            User::where('id',$user->id)->update(['name'=>$name]);
        }
    }
}
