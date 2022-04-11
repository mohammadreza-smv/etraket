<?php

namespace Modules\catBrands\Models;


use App\CustomModel;
use Modules\brands\Models\Brand;
use Modules\categories\Models\Category;

class CatBrand extends CustomModel
{
    protected $guarded=[];
    public function getBrand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }
    public function getCategory()
    {
        return $this->hasOne(Category::class,'id','cat_id');
    }
}
