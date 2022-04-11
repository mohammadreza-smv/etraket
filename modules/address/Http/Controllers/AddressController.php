<?php


namespace Modules\address\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\address\Repository\AddressRepositoryInterface;
use Auth;
class AddressController extends Controller
{
   public function create(Request $request,AddressRepositoryInterface $repository){
       return $repository->create($request);
   }

   public function destroy($address_id,Request $request,AddressRepositoryInterface $repository){
       return $repository->delete($address_id,$request);
   }

   public function update(Request $request,AddressRepositoryInterface $repository){
       return $repository->update($request);
   }

   public function getAddress(AddressRepositoryInterface $repository){
       $user_id=Auth::user()->id;
       return $repository->paginate($user_id);
   }
}
