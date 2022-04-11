<?php


namespace Modules\catBrands\Repository;


interface CatBrandRepositoryInterface
{
    public function create($cat_id,$brand_id);

    public function CreateOrUpdate($cat_id,$brand_id);

    public function addCatBrand($product,$oldData);

    public function getWithRelation($relation,$where);

}
