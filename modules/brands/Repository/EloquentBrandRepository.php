<?php


namespace Modules\brands\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\brands\Models\Brand;

class EloquentBrandRepository extends EloquentBaseRepository implements BrandRepositoryInterface
{
    protected $model='Modules\brands\Models\Brand';

    public function find($id)
    {
        return Brand::findOrFail($id);
    }

    public function create($request)
    {
        $brand=new Brand($request->all());
        $img_url=upload_file($request,'pic','upload');
        $brand->brand_icon=$img_url;
        $brand->saveOrFail();
    }

    public function trashCount()
    {
        return Brand::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Brand::getData($request->all());
    }

    public function update($id, $request)
    {
        $brand=Brand::findOrFail($id);
        $img_url=upload_file($request,'pic','upload');
        if($img_url){
            $brand->brand_icon=$img_url;
        }
        $brand->update($request->all());
    }

    public function selectList(): array
    {
        $brand['']='انتخاب برند';
        return $brand+Brand::pluck('brand_name','id')->toArray();
    }

    public function firstOrFail($where){
        return Brand::where($where)->firstOrFail();
    }
}
