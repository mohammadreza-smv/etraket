<?php


namespace Modules\pages\Repository;


use App\Repositories\BaseInterface;

interface PageRepositoryInterface extends BaseInterface
{
    public function findPage($where);
}
