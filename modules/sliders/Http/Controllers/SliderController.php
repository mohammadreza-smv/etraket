<?php

namespace Modules\sliders\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Modules\sliders\Http\Requests\SliderRequest;
use Illuminate\Http\Request;
use Modules\sliders\Repository\SliderRepositoryInterface;

class SliderController extends CustomController
{
    protected $title='اسلایدر';

    protected $route_params='sliders';

    protected $repository=null;

    public function __construct(SliderRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request)
    {
        $sliders=$this->repository->getList($request);
        $trash_slider_count=$this->repository->trashCount();
        return CView('sliders::panel.index',['sliders'=>$sliders,'trash_slider_count'=>$trash_slider_count,'req'=>$request]);
    }

    public function create()
    {
        return CView('sliders::panel.create');
    }

    public function store(SliderRequest $request)
    {
        $this->repository->create($request);

        return  [
            'redirect_url'=>url('admin/sliders'),
            'message'=>'ثبت اسلایدر با موفقیت انجام شد'
        ];

    }
    public function edit($id)
    {
        $slider=$this->repository->find($id);
        return CView('sliders::panel.edit',['slider'=>$slider]);
    }
    public function update($id,SliderRequest $request)
    {
        $this->repository->update($id,$request);

        return  [
            'redirect_url'=>url('admin/sliders'),
            'message'=>'ویرایش اسلایدر با موفقیت انجام شد'
        ];

    }
}
