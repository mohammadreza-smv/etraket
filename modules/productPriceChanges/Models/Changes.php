<?php


namespace Modules\productPriceChanges\Models;


use App\Lib\Jdf;
use Modules\priceVariation\Models\PriceVariation;

class Changes
{
    protected $model;
    protected $year;
    protected $mount;
    protected $day;

    public function __construct($model,$type=null)
    {
        $this->model=$model;
        $jdf=new Jdf();
        $this->year=$jdf->tr_num($jdf->jdate('Y'));
        $this->mount=$jdf->tr_num($jdf->jdate('n'));
        $this->day=$jdf->tr_num($jdf->jdate('j'));
        if($type=='deleted') {
            $this->checkHasPriceVariation();
        }
        else{
            $this->setChanges();
        }
    }

    protected function setChanges(){
        $row=$this->checkHasRow();
        if($row){
            if($this->model->price2<$row->price || $row->price==0){
                $row->update([
                    'price'=> $this->model->price2,
                    'param1_type'=>$this->model->param1_type,
                    'param1_id'=>$this->model->param1_id,
                    'price_variation_id'=>$this->model->id,
                ]);
            }
        }
        else{
            $this->insertNewRecord();
        }
    }

    protected function checkHasRow(){
        $has_row=PriceChanges::where(
            [
                'Year'=>$this->year,
                'mount'=>$this->mount,
                'day'=>$this->day,
                'product_id'=>$this->model->product_id,
                'param1_type'=>$this->model->param1_type,
                'param1_id'=>$this->model->param1_id
              ]
            )->first();
        return $has_row;
    }

    protected function insertNewRecord(){
        $priceChanges=new PriceChanges([
            'Year'=>$this->year,
            'mount'=>$this->mount,
            'day'=>$this->day,
            'param1_type'=>$this->model->param1_type,
            'param1_id'=>$this->model->param1_id,
            'product_id'=>$this->model->product_id,
            'price'=>$this->model->price2,
            'time'=>time(),
            'price_variation_id'=>$this->model->id
        ]);
        $priceChanges->save();
    }

    protected function checkHasPriceVariation(){

        $priceVariation=$this->getFirstPriceVariation();

        $price=$priceVariation ? $priceVariation->price2 : 0;

        $row=$this->checkHasRow();

        $price_variation_id=$row ? $row->id : 0;

        if($row)
        {
            $row->price=$price;
            $row->price_variation_id=$price_variation_id;
            $row->update();
        }
        else{
            PriceChanges::create([
                'Year'=>$this->year,
                'mount'=>$this->mount,
                'day'=>$this->day,
                'param1_type'=>$this->model->param1_type,
                'param1_id'=>$this->model->param1_id,
                'product_id'=>$this->model->product_id,
                'price'=>$price,
                'time'=>time(),
                'price_variation_id'=>$price_variation_id
            ]);
        }
    }

    protected function getFirstPriceVariation(){
        return PriceVariation::where(
            [
                'product_id'=>$this->model->product_id,
                'param1_type'=>$this->model->param1_type,
                'param1_id'=>$this->model->param1_id,
            ])
            ->where('product_number','>',0)->orderBy('price2','ASC')->first();
    }

}
