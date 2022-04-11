<?php


namespace Modules\productPriceChanges\Models;


use App\CustomModel;
use Modules\priceVariation\Models\PriceVariation;

class PriceChanges extends CustomModel
{
    protected $table='product_price_changes';

    protected $guarded=[];

    public function priceVariation(){
        return $this->belongsTo(PriceVariation::class,'id','product_id');
    }
}
