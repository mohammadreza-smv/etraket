<?php

namespace Modules\affiliate;

use App\BaseModule;
use Modules\brands\Models\Brand;
use Modules\categories\Models\Category;

class Module extends BaseModule
{
    public function affiliate__commissions_category_relation(){
        return function($self){
            return $self->hasone(Category::class,'id','cat_id');
        };
    }

    public function affiliate__commissions_brand_relation(){
        return function($self){
            return $self->hasone(Brand::class,'id','brand_id');
        };
    }
}
