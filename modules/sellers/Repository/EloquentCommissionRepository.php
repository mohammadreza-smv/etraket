<?php

namespace Modules\sellers\Repository;

use App\Repositories\BaseInterface;
use App\Repositories\EloquentBaseRepository;
use Modules\brands\Models\Brand;
use Modules\categories\Models\Category;
use Modules\sellers\Models\Commission;

class EloquentCommissionRepository extends EloquentBaseRepository  implements CommissionRepositoryInterface
{
    protected $model="Modules\sellers\Models\Commission";

    public function find($id)
    {
        return Commission::findOrFail($id);
    }

    public function create($request)
    {
        $commission=new Commission($request->all());
        $commission->saveOrFail();
    }

    public function trashCount()
    {
         return Commission::onlyTrashed()->count();
    }

    public function getList($request)
    {
         return Commission::getData($request->all());
    }

    public function update($id, $request)
    {
        $commission=Commission::findOrFail($id);
        $commission->update($request->all());
    }

    public function getCategories()
    {
        if(file_exists(base_path('modules/categories/Models/Category.php'))){
            return Category::catList2();
        }
        else{
            return  [];
        }
    }

    public function getBrands()
    {
        if(file_exists(base_path('modules/brands/Models/Brand.php'))){
            return [''=>'انتخاب برند']+Brand::pluck('brand_name','id')->toArray();
        }
        else{
            return  [];
        }
    }

    public function checkHas($request)
    {
        $cat_id=$request->get('cat_id');
        $brand_id=$request->get('brand_id');
        return Commission::where(['cat_id'=>$cat_id,'brand_id'=>$brand_id])->first();
    }
}
