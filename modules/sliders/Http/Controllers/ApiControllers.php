<?php


namespace Modules\sliders\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\sliders\Repository\SliderRepositoryInterface;

class ApiControllers extends Controller
{
    public function sliders(SliderRepositoryInterface $repository){
        return $repository->all();
    }
}
