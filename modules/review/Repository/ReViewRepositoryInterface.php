<?php


namespace Modules\review\Repository;


use App\Repositories\BaseInterface;

interface ReViewRepositoryInterface extends BaseInterface
{
    public function setProductId($id);

    public function getPrimary($product_id);

    public function addPrimary($product_id,$request);

    public function getProductReview($product_id);
}
