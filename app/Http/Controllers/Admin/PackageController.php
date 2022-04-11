<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Package;
use App\Seller;
use App\Stockroom;
use Session;
class PackageController extends CustomController
{
    protected  $model='Package';
    protected  $title='محموله ها';
    protected $route_params='packages';
    public function index(Request $request)
    {
        $stockroom=[''=>'انتخاب انبار']+Stockroom::pluck('name','id')->toArray();
        $sellers=[''=>'انتخاب فروشنده']+Seller::pluck('brand_name','id')->toArray();
        $packages=Package::getData($request->all());
        $trash_packages_count=Package::onlyTrashed()->count();
        return view('packages.index',[
            'packages'=>$packages,'trash_packages_count'=>$trash_packages_count,'req'=>$request,
            'stockroom'=>$stockroom,
            'sellers'=>$sellers
        ]);
    }
    public function show($id)
    {
        $package=Package::where('id',$id)->with('getStockroom')->firstOrFail();
        return view('packages.show',['package'=>$package]);
    }
    public function getContent($id)
    {
        return Package::getPackageProduct($id);
    }
    public function add_product(Request $request)
    {
        $package_id=$request->get('package_id');
        $package=Package::where('id',$package_id)->firstOrFail();
        if($package){
            $package->status=$request->get('status');
            $package->update();
            if($request->get('addProduct')=="true")
            {
                return Stockroom::add_product($request);
            }
            else{
                Session::flash('message','ثبت تغییرات با موفقیت انجام شد');
                return 'add';
            }
        }
        else{
            return 'error';
        }
    }
}
