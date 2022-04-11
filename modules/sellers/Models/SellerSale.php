<?php

namespace Modules\sellers\Models;

use App\Lib\Jdf;
use DB;

class SellerSale
{
    protected $variation;

    protected $year;

    protected $month;

    protected $day;

    protected $product;

    protected $commission_price=0;

    protected $product_price=0;

    public function __construct($variation)
    {
        $this->variation=$variation;
        $jdf=new Jdf();
        $this->year=$jdf->tr_num($jdf->jdate('Y'));
        $this->month=$jdf->tr_num($jdf->jdate('n'));
        $this->day=$jdf->tr_num($jdf->jdate('j'));
        $this->product=$variation->product;
        $this->addCommission();
        $this->addSaleStatistics();
    }

    public function addCommission(){
        $where=[];
        if(intval($this->product->cat_id)>0){
            $where['cat_id']=$this->product->cat_id;
        }
        if(intval($this->product->brand_id)>0){
            $where['brand_id']=$this->product->brand_id;
        }
        $commission=Commission::where($where)->first();
        $this->product_price=$this->variation->product_price2*$this->variation->product_count;
        if($commission){
            $c=($this->variation->product_price2*$commission->percentage)/100;
            $c=($c*$this->variation->product_count);
            $this->commission_price=$c;
            DB::table('sellers')->where('id',$this->variation->seller_id)->increment('total_commission', $this->commission_price);
            DB::table('sellers')->where('id',$this->variation->seller_id)->increment('total_price',$this->product_price);
        }
    }

    public function addSaleStatistics(){

        $seller_sale=DB::table('seller_sale_statistics')
            ->where(['year'=>$this->day,'month'=>$this->month,'day'=>$this->day,'seller_id'=>$this->variation->seller_id])->first();


        if($seller_sale)
        {
            $commission=$this->commission_price+$seller_sale->commision;
            $product_price=$this->product_price+$seller_sale->price;

            DB::table('seller_sale_statistics')
                ->where(['year'=>$this->year,'month'=>$this->month,'day'=>$this->day,'seller_id'=>$this->variation->seller_id])
                ->update([
                    'price'=>$product_price,
                    'commission'=>$commission
                ]);
        }
        else{
            DB::table('seller_sale_statistics')
                ->insert([
                    'year'=>$this->year,
                    'month'=>$this->month,
                    'day'=>$this->day,
                    'seller_id'=>$this->variation->seller_id,
                    'commission'=>$this->commission_price,
                    'price'=>$this->product_price
                ]);
        }
    }
}
