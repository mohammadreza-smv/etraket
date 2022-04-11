<?php


namespace Modules\users\Http\Controllers;


use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return CView('users::admin.index');
    }

    public function error403()
    {
        return CView('users::admin.403');
    }
}
