<?php


namespace Modules\brands\Repository;


use App\Repositories\BaseInterface;

interface BrandRepositoryInterface extends BaseInterface
{
    public function selectList() : array ;

    public function firstOrFail($where);
}
