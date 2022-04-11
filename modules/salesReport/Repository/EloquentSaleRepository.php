<?php


namespace Modules\salesReport\Repository;
use DB;
use \Illuminate\Support\Facades\Schema;
use Modules\address\Models\Address;
use Modules\orders\Models\Orders;
use Modules\province\Models\Province;

class EloquentSaleRepository implements SaleRepositoryInterface
{
    public function set_province_order_count($order)
    {
        $address=Address::where('id',$order->address_id)->first();
        if($address){
            Province::where(['id'=>$address->province_id])->increment('order_count');
        }
    }

    public function set_order_sale($order_id)
    {
        if(Schema::hasTable("province") && file_exists(base_path('modules/address/Models/Address.php'))){
            $order=Orders::where(['id'=>$order_id,'pay_status'=>'ok'])
                ->with(['submissions.products.product'])->select(['id','address_id'])->first();
            if($order){
                $this->set_province_order_count($order);
               foreach ($order->submissions as $submission){
                   foreach ($submission->products as $product){
                       run_action('add_product_sale',[$product]);
                   }
               }
            }
        }
    }
}
