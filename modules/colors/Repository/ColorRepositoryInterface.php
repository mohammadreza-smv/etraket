<?php


namespace Modules\colors\Repository;


use App\Repositories\BaseInterface;

interface ColorRepositoryInterface extends BaseInterface
{
    public function selectList();

    public function setProductColor($price_variation);

    public function getColorCategory($catId);

    public function all();
}
