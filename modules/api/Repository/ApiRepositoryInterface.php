<?php


namespace Modules\api\Repository;


interface ApiRepositoryInterface
{
   public function product_list($request);

   public function categories();

   public function child_categories($catId);

   public function catProduct($catId,$order);

   public function incredible_offers();
}
