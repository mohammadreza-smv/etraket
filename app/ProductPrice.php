<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
   protected $table='product_price';
   protected $fillable=['warranty_id','time','Year','mount','day','price','product_id','color_id'];
   public function getColor()
   {
       return $this->hasOne(Color::class,'id','color_id');
   }
   public function getProductWarranty()
   {
        return $this->hasOne(ProductWarranty::class,'id','warranty_id');
   }
}
