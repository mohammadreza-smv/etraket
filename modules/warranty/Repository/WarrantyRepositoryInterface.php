<?php


namespace Modules\warranty\Repository;


use App\Repositories\BaseInterface;

interface WarrantyRepositoryInterface extends BaseInterface
{
    public function selectList():array ;
}
