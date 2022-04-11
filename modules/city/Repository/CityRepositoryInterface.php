<?php


namespace Modules\city\Repository;


use App\Repositories\BaseInterface;

interface CityRepositoryInterface extends BaseInterface
{
    public function provinces() :array ;

    public function first($id);

    public function arrayList($where=[]);

    public function allCitiesForProvince($where=[]);

    public function all($where=[],$select);
}
