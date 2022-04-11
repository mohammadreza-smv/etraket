<?php

namespace Modules\items\Models;

use Illuminate\Database\Eloquent\Model;

class ItemValue extends Model
{
    protected $table='item_value';

    protected $guarded=[];

    public function important_item()
    {
        return $this->hasOne(Item::class,'id','item_id')
            ->where('show_item',1);
    }
}
