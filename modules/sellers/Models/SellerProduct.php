<?php

namespace Modules\sellers\Models;

use App\CustomModel;
use Modules\products\Models\Product;

class SellerProduct extends CustomModel
{

    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }

    public $timestamps = false;
}
