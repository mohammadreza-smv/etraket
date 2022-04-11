<?php


namespace Modules\address\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\address\Repository\AddressRepositoryInterface;

class ApiController extends Controller
{
    public function addAddress(Request $request,AddressRepositoryInterface $repository){
        $data=$request->all();
        $data['user_id']=$request->user()->id;
        if($request->get('userOrder')=="true"){
            $data['name']=$request->user()->name;
            $data['mobile']=$request->user()->mobile;
        }
        $id=$repository->add($data);
        return $id;
    }

    public function address_list(Request $request,AddressRepositoryInterface $repository){
        $user_id=$request->user()->id;
        return $repository->paginate($user_id);
    }

    public function update_address($id,Request $request,AddressRepositoryInterface $repository){
        $user_id=$request->user()->id;
        $data=$request->all();
        if($request->get('userOrder')=="true"){
            $data['name']=$request->user()->name;
            $data['mobile']=$request->user()->mobile;
        }
        $repository->edit($id,$user_id,$data);
        return 'ok';
    }

    public function remove_address(Request $request,AddressRepositoryInterface $repository){

        $address_id=$request->get('id');
        $repository->delete($address_id,$request,false);
        return 'ok';
    }
}
