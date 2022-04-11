<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    public function getProductWarranty()
    {
        return $this->hasOne(ProductWarranty::class,'id','warranty_id')
            ->with('getColor')
            ->with('getWarranty')
            ->withTrashed();
    }
}
