<?php


namespace Modules\priceVariation\Repository;


use App\Repositories\BaseInterface;

interface PriceVariationRepositoryInterface extends BaseInterface
{
    public function VariationItem($cat_id);

    public function setProductMainPrice($price_variation);

    public function checkInsert($request,$id=0);

    public function setVariation($param1,$param2,$product_id);

    public function first($where,$relation);

    public function all($whereIn,$relation);

    public function trashCountWithWhere($where);

    public function productVariations($where,$relation);
}
