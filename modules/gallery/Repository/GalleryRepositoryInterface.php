<?php


namespace Modules\gallery\Repository;


interface GalleryRepositoryInterface
{
    public function all($product_id);

    public function add($request,$product_id);

    public function remove($image);

    public function find($id);

    public function change_images_position($product_id,$request);
}
