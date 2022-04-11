<?php


namespace Modules\address\Repository;

use DB;
use Auth;
use Modules\address\Models\Address;

class EloquentAddressRepository  implements AddressRepositoryInterface
{

    public function all($user_id)
    {
        $address=Address::with(['getProvince','getCity'])->where('user_id',$user_id)
            ->orderBy('id','DESC')->get();
        return $address;
    }

    public function create($request)
    {
        $id=$request->get('id',0);
        if($id==0){
            $user_id=$request->user()->id;

            $address=new Address($request->all());
            $address->user_id=$user_id;
            if($address->save())
            {
                if($request->get('paginate')=='ok'){
                    $addressList=$this->paginate($user_id);
                }
                else{
                    $addressList=$this->all($user_id);
                }
                return $addressList;
            }
            else{
                return 'error';
            }
        }
        else{
            return $this->update($request);
        }
    }

    public function paginate($user_id){
        $address=Address::with(['getProvince','getCity'])->where('user_id',$user_id)
            ->orderBy('id','DESC')->paginate(10);
        return $address;
    }

    public function delete($address_id,$request,$getList=true)
    {
        $user_id=$request->user()->id;
        $delete=Address::where(['user_id'=>$user_id,'id'=>$address_id])->delete();
        if($delete)
        {
            if($getList){
                if($request->get('paginate')=='ok'){
                    $AddressList=$this->paginate($user_id);
                }
                else{
                    $AddressList=$this->all($user_id);
                }
                return $AddressList;
            }
        }
        else{
            return 'error';
        }
    }

    public function update($request)
    {
        $user_id=$request->user()->id;
        $id=$request->get('id',0);
        $address=Address::where(['id'=>$id,'user_id'=>$user_id])->first();
        if($address)
        {
            $address->update($request->all());
            if($request->get('paginate')=='ok'){
                $addressList=$this->paginate($user_id);
            }
            else{
                $addressList=$this->all($user_id);
            }
            return $addressList;
        }
        else{
            return 'error';
        }
    }

    public function first($where,$withTrashed=false,$relation=[])
    {
        $address=Address::where($where);
        if($withTrashed){
            $address=$address->withTrashed();
        }
        if(sizeof($relation)>0){
            $address=$address->with($relation);
        }
        $address=$address->first();
        return $address;
    }

    public function add($data)
    {
        $address=new Address($data);
        $address->save();
        return $address->id;
    }

    public function edit($id,$user_id,$data)
    {
        $address=Address::where(['id'=>$id,'user_id'=>$user_id])->first();
        if($address){
            $address->update($data);
        }
    }
}
