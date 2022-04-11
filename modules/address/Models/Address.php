<?php

namespace Modules\address\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\city\Models\City;
use Modules\province\Models\Province;

class Address extends CustomModel
{
    use SoftDeletes;
    protected $table='address';
    protected $guarded=['paginate','id'];
    public function getProvince()
    {
        return $this->belongsTo(Province::class,'province_id','id')
            ->withDefault(['name'=>'']);
    }
    public function getCity()
    {
        return $this->belongsTo(City::class,'city_id','id')
            ->withDefault(['name'=>''])->select(['id','name']);
    }
}
