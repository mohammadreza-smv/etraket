<?php


namespace Modules\productComparison\Repository;


interface ProductComparisonRepositoryInterface
{
    public function products($ids);

    public function getCategory($id);

    public function getItemsForCategory($category);

    public function getSearchBrand($request);

    public function getProductForComparison($request);
}
