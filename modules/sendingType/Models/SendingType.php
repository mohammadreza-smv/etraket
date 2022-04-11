<?php

namespace Modules\sendingType\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class SendingType extends CustomModel
{
    use SoftDeletes;
    protected $table='send_type_order';
    protected $guarded=['pic'];
    public static function getData($request)
    {
        $string='?';
        $pages=self::orderBy('id','DESC');
        if(inTrashed($request)){
            $pages=$pages->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        $pages=$pages->paginate(10);
        $pages->withPath($string);
        return $pages;
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function($row){
            if($row->isForceDeleting())
            {
                $key=$row->type_key;
                define('key',$key);
                if(Schema::hasTable('city')){
                    Schema::table('city', function (Blueprint $table) {
                        $table->dropColumn(key.'_send_time');
                        $table->dropColumn(key.'_send_price');
                        $table->dropColumn(key.'_min_order_price');
                    });
                }
            }
        });
    }
}
