<?php

namespace Modules\colors\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends CustomModel
{
    protected $table='product_color';

    protected $guarded=[];

    public function getColor()
    {
        return $this->hasOne(Color::class,'id','color_id');
    }
}
