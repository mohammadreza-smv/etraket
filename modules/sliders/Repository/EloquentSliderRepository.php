<?php


namespace Modules\sliders\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\sliders\Models\Slider;

class EloquentSliderRepository extends EloquentBaseRepository implements SliderRepositoryInterface
{
    protected $model='Modules\sliders\Models\Slider';
    public function find($id)
    {
        return Slider::findOrFail($id);
    }

    public function create($request)
    {
        $slider=new Slider($request->all());
        $image_url=upload_file($request,'pic','slider','desktop');
        $mobile_image_url=upload_file($request,'mobile_pic','slider','mobile');
        $slider->image_url=$image_url;
        $slider->mobile_image_url=$mobile_image_url;
        $slider->saveOrFail();
    }

    public function trashCount()
    {
        return Slider::onlyTrashed()->count();
    }

    public function getList($request)
    {
       return Slider::getData($request->all());
    }

    public function update($id, $request)
    {
        $slider=Slider::findOrFail($id);
        $image_url=upload_file($request,'pic','slider','desktop');
        $mobile_image_url=upload_file($request,'mobile_pic','slider','mobile');
        if($image_url!=null){
            $slider->image_url=$image_url;
        }
        if($mobile_image_url!=null){
            $slider->mobile_image_url=$mobile_image_url;
        }
        $slider->update($request->all());
    }

    public function all()
    {
        return Slider::OrderBy('id','DESC')->get();
    }
}
