<?php


namespace Modules\favourite\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\favourite\Repository\FavoriteRepositoryInterface;

class ApiController extends Controller
{
    public function add_or_remove(Request $request,FavoriteRepositoryInterface $repository){
        return $repository->add($request);
    }

    public function favourite_list(Request $request,FavoriteRepositoryInterface $repository){
        $user_id=$request->user()->id;
        return $repository->FavoriteList($user_id);
    }

    public function remove_favourite(Request $request,FavoriteRepositoryInterface $repository){

         $user_id=$request->user()->id;
         $product_id=$request->get('product_id');
         return $repository->remove($user_id,$product_id,$request);
    }
}
