<?php


namespace Modules\filters\Repository;


interface FilterRepositoryInterface
{
    public function all($cat_id);

    public function addFilter($filter,$child_filter,$cat_id);

    public function product_filters($product);

    public function add_product_filters($product,$request);

    public function catFilters($relation,$where,$categories);
}
