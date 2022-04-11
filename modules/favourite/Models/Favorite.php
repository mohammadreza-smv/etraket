<?php

namespace Modules\favourite\Models;

use App\CustomModel;
use Modules\products\Models\Product;

class Favorite extends CustomModel
{
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
