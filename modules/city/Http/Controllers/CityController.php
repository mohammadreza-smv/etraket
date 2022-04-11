<?php

namespace Modules\city\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\city\Http\Requests\CityRequest;
use Modules\city\Repository\CityRepositoryInterface;

class CityController extends CustomController
{
    protected $title='شهر';

    protected $route_params='city';

    protected $repository=null;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $city=$this->repository->getList($request);
        $trash_city_count=$this->repository->trashCount();
        return CView('city::index',['city'=>$city,'trash_city_count'=>$trash_city_count,'req'=>$request]);
    }

    public function create()
    {
        $province=$this->repository->provinces();
        return CView('city::create',compact('province'));
    }

    public function store(CityRequest $request)
    {
        $this->repository->create($request);

        return  [
            'redirect_url'=>url('admin/city'),
            'message'=>'ثبت  شهر جدید با موفقیت انجام شد'
        ];

    }

    public function edit($id)
    {
        $city=$this->repository->find($id);
        $province=$this->repository->provinces();
        return CView('city::edit',compact('city','province'));
    }

    public function update($id,CityRequest $request)
    {
        $this->repository->update($id,$request);

        return  [
            'redirect_url'=>url('admin/city'),
            'message'=>'ویرایش شهر با موفقیت انجام شد'
        ];

    }

    public function getList($province_id){
        return $this->repository->allCitiesForProvince(['province_id'=>$province_id]);
    }
}
