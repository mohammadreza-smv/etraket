<?php


namespace Modules\province\Repository;


use App\Repositories\BaseInterface;

interface ProvinceRepositoryInterface extends BaseInterface
{
    public function arrayList();

    public function all();
}
