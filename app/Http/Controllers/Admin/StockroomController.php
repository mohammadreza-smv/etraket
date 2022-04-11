<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stockroom;
use App\ProductWarranty;
use Illuminate\Database\Eloquent\Builder;
use App\StockroomEvent;
use App\InventoryList;
use App\Seller;
class StockroomController extends CustomController
{
    protected  $model='Stockroom';
    protected  $title='انبار';
    protected  $route_params='stockrooms';
    public function index(Request $request)
    {
        $stockrooms=Stockroom::getData($request->all());
        $trash_stockroom_count=Stockroom::onlyTrashed()->count();
        return view('stockroom.index',['stockrooms'=>$stockrooms,'trash_stockroom_count'=>$trash_stockroom_count,'req'=>$request]);
    }
    public function create()
    {
        return view('stockroom.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required|unique:stockrooms'],[],['name'=>'نام انبار']);
        $Stockroom=new Stockroom($request->all());
        $Stockroom->saveOrFail();
        return redirect('admin/stockrooms')->with('message','ثبت انبار با موفقیت انجام شد');
    }
    public function edit($id)
    {
        $Stockroom=Stockroom::findOrFail($id);
        return view('stockroom.edit',['Stockroom'=>$Stockroom]);
    }
    public function update($id,Request $request)
    {
        $this->validate($request,['name'=>'required|unique:stockrooms,name,'.$id.''],[],['name'=>'نام انبار']);
        $Stockroom=Stockroom::findOrFail($id);
        $Stockroom->update($request->all());
        return redirect('admin/stockrooms')->with('message','ویرایش انبار با موفقیت انجام شد');
    }
    public function add_input()
    {
        $stockroom=Stockroom::get();
        return view('stockroom.add_input',['stockroom'=>$stockroom]);
    }
    public function add_output()
    {
        $stockroom=Stockroom::get();
        return view('stockroom.add_output',['stockroom'=>$stockroom]);
    }
    public function getProductWarrnty(Request $request)
    {
        $search_text=$request->get('search_text','');
        $product_warranty=ProductWarranty::with(['getProduct','getWarranty','getSeller','getColor']);
        if(!empty($search_text))
        {
            define('title',$search_text);
            $product_warranty=$product_warranty->whereHas('getProduct',function(Builder $query){
                $query->where('title','like','%'.title.'%');
            });
        }
        else{
            $product_warranty=$product_warranty->whereHas('getProduct');
        }
        $product_warranty=$product_warranty->paginate(5);

        return $product_warranty;
    }
    public function add_product(Request $request)
    {
        return Stockroom::add_product($request);
    }
    public function input(Request $request)
    {
        $stockroom=[''=>'انتخاب انبار']+Stockroom::pluck('name','id')->toArray();
        $stockroomEvent=StockroomEvent::getList($request,'input');
        return view('stockroom.input',['stockroomEvent'=>$stockroomEvent,'stockroom'=>$stockroom,'req'=>$request]);
    }
    public function output(Request $request)
    {
        $stockroom=[''=>'انتخاب انبار']+Stockroom::pluck('name','id')->toArray();
        $stockroomEvent=StockroomEvent::getList($request,'output');
        return view('stockroom.output',['stockroomEvent'=>$stockroomEvent,'stockroom'=>$stockroom,'req'=>$request]);

    }
    public function show_input($id,Request $request)
    {
        $input=Stockroom::getPorudtList($id,"input",$request);
        return view('stockroom.show_input',['input'=>$input,'req'=>$request]);
    }
    public function show_output($id,Request $request)
    {
        $output=Stockroom::getPorudtList($id,"output",$request);
        return view('stockroom.show_output',['output'=>$output,'req'=>$request]);
    }
    public function show($id,Request $request)
    {
        $stockroom=Stockroom::findOrFail($id);
        $inventory_lists=InventoryList::getList($id,$request);

        $seller=[''=>'انتخاب فروشنده',0=>env('SHOP_NAME','')]+Seller::pluck('brand_name','id')->toArray();
        return view('stockroom.list',['inventory_lists'=>$inventory_lists,'req'=>$request,'stockroom'=>$stockroom,'seller'=>$seller]);
    }
    public function getInventory(Request $request)
    {
        $stockroom_id=$request->get('stockroom_id',0);
        return InventoryList::getList($stockroom_id,$request,5);
    }
    public function input_factor($id,Request $request)
    {
        $input=Stockroom::getPorudtList($id,"input",$request);
        $type="input";
        return view('stockroom.factor',['type'=>$type,'input'=>$input]);
    }
    public function output_factor($id,Request $request)
    {
        $input=Stockroom::getPorudtList($id,"output",$request);
        $type="output";
        return view('stockroom.factor',['type'=>$type,'input'=>$input]);
    }
}
