<?php


namespace Modules\address\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\address\Repository\AddressRepositoryInterface;

class UserController extends Controller
{
    public function address(Request $request){
        $user_id=$request->user()->id;
        return CView('address::'.$this->view.'userPanel.address');
    }
}
