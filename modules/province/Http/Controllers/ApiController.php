<?php


namespace Modules\province\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\province\Repository\ProvinceRepositoryInterface;

class ApiController extends Controller
{
    public function provinces(ProvinceRepositoryInterface $repository){
        return $repository->all();
    }
}
