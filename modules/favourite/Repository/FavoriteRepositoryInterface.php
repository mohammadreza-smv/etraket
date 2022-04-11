<?php


namespace Modules\favourite\Repository;


interface FavoriteRepositoryInterface
{
    public function checkSelected($user_id,$product_id);

    public function add($request);

    public function FavoriteList($user_id);

    public function remove($user_id,$product_id,$request);
}
