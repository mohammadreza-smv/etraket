<?php


namespace Modules\favourite\Http\Controllers;


use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function favorite(){
        return CView('favourite::'.$this->view.'favorite');
    }
}
