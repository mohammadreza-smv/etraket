<?php

namespace Modules\sellers\Models;


use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends CustomModel
{
    protected $guarded = [];


    public static function getData($request)
    {
        $string = '?';
        $payments = self::with('seller');
        if (array_key_exists('date', $request) && !empty($request['date'])) {
            $date = $request['date'];
            $first = getTimestamp($date, 'first');
            $last = getTimestamp($date, 'last');
            $payments = $payments->whereBetween('time', [$first, $last]);
            $string = create_paginate_url($string, 'date=' . $request['date']);
        }
        if (array_key_exists('seller_id', $request) && !empty($request['seller_id'])) {
            $payments = $payments->where('seller_id', $request['seller_id']);
            $string = create_paginate_url($string, 'seller_id=' . $request['seller_id']);
        }
        $payments = $payments->orderBy('id', 'DESC')->paginate(10);
        $payments->withPath($string);
        return $payments;
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class,'seller_id', 'id')
            ->withTrashed()->withDefault(['brand_name'=>'']);
    }
}
