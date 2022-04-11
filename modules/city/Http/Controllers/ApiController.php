<?php


namespace Modules\city\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\city\Repository\CityRepositoryInterface;

class ApiController extends Controller
{
    public function getArrayList($province_id,CityRepositoryInterface $repository){
        return $repository->all(['province_id'=>$province_id]);
    }

    public function getCites(CityRepositoryInterface $repository){
        return $repository->all([],['id','name']);
    }
}
