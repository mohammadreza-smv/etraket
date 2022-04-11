<?php


namespace Modules\orders\Models;


use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\products\Models\Product;

class OrderProducts extends CustomModel
{
    use SoftDeletes;

    protected $table='orders__products';

    protected $guarded=[];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function param1()
    {
        return $this->morphTo();
    }

    public function param2()
    {
        return $this->morphTo();
    }
}
