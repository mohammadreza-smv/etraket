<?php

namespace Modules\products;

use App\BaseModule;

class Module extends BaseModule
{
    public function set_user_access_list($access){
        $access['products']=[
            'label'=>'محصولات',
            'access'=>[
                'product_edit'=>['label'=>'ثبت و ویرایش محصولات','routes'=>[
                    'products.index','products.create','products.store','products.edit','products.update'
                ]],
                'remove_product'=>['label'=>'حذف محصولات','routes'=>['products.index','products.destroy']],
                'restore_product'=>['label'=>'بازیابی محصولات','routes'=>['products.index','products.restore']]
            ]
        ];

        return $access;
    }
}
