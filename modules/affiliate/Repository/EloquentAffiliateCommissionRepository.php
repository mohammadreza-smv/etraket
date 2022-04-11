<?php

namespace Modules\affiliate\Repository;

use App\Repositories\EloquentBaseRepository;
use Modules\brands\Models\Brand;
use Modules\categories\Models\Category;
use Modules\affiliate\Models\AffiliateCommission;

class EloquentAffiliateCommissionRepository extends EloquentBaseRepository  implements AffiliateCommissionRepositoryInterface
{
    protected $model="Modules\affiliate\Models\AffiliateCommission";

    public function find($id)
    {
        return AffiliateCommission::findOrFail($id);
    }

    public function create($request)
    {
        $commission=new AffiliateCommission($request->all());
        $commission->saveOrFail();
    }

    public function trashCount()
    {
         return AffiliateCommission::onlyTrashed()->count();
    }

    public function getList($request)
    {
         return AffiliateCommission::getData($request->all());
    }

    public function update($id, $request)
    {
        $commission=AffiliateCommission::findOrFail($id);
        $commission->update($request->all());
    }

    public function getCategories()
    {
        if(file_exists(base_path('modules/categories/models/Category.php'))){
            return Category::catList2();
        }
        else{
            return  [];
        }
    }

    public function getBrands()
    {
        if(file_exists(base_path('modules/brands/models/Brand.php'))){
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
        return AffiliateCommission::where(['cat_id'=>$cat_id,'brand_id'=>$brand_id])->first();
    }
}
