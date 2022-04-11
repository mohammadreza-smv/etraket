<?php


namespace Modules\priceVariation\Repository;


interface VariationItemsInterface
{
    public function addItems($cat_id,$data);

    public function params($cat_id);

    public function find($id);

    public function destroy($id);

    public function getParam($key,$catId);

}
