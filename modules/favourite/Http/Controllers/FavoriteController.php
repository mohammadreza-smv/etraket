<?php


namespace Modules\favourite\Http\Controllers;


use Illuminate\Http\Request;
use Modules\favourite\Repository\FavoriteRepositoryInterface;

class FavoriteController
{
    public function add_favorite(Request $request,FavoriteRepositoryInterface $repository)
    {
        return $repository->add($request);
    }

    public function getFavoriteList(Request $request,FavoriteRepositoryInterface $repository)
    {
        if($request->header('X-Xsrf-Token',NULL)){
            $user_id=$request->user()->id;
            return $repository->FavoriteList($user_id);
        }
    }

    public function removeProductOfList(Request $request,FavoriteRepositoryInterface $repository)
    {
        if($request->header('X-Xsrf-Token',NULL)){
            $user_id=$request->user()->id;
            $product_id=$request->get('product_id');
            return $repository->remove($user_id,$product_id,$request);
        }
    }

}
