<?php


namespace Modules\favourite\Repository;


use Modules\favourite\Models\Favorite;

class EloquentFavoriteRepository  implements FavoriteRepositoryInterface
{

    public function checkSelected($user_id,$product_id){
       return Favorite::where(['product_id'=>$product_id,'user_id'=>$user_id])->first();
    }

    public function add($request)
    {
        $product_id=$request->get('product_id');
        $user_id=$request->user()->id;
        $favorite=Favorite::where(['product_id'=>$product_id,'user_id'=>$user_id])->first();
        if($favorite){
            $favorite->delete();
            return 'ok';
        }
        else{
            $favorite=new Favorite($request->all());
            $favorite->user_id=$user_id;
            $favorite->saveOrFail();
            return 'ok';
        }
    }

    public function FavoriteList($user_id)
    {
        return Favorite::with('product')
            ->where('user_id',$user_id)
            ->orderBy('id','DeSC')
            ->paginate(10);
    }

    public function remove($user_id, $product_id,$request)
    {
        Favorite::where(['product_id'=>$product_id,'user_id'=>$user_id])->delete();
        if($request->get('showMobile')=='ok'){
            return 'ok';
        }
        else{
            return Favorite::with('product')
                ->where('user_id',$user_id)->orderBy('id','DESC')
                ->paginate(10);
        }
    }
}
