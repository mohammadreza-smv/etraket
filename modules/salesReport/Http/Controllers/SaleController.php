<?php

namespace Modules\salesReport\Http\Controllers;

use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    public function province(){
        return CView('salesReport::province');
    }
}
