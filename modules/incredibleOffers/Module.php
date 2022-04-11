<?php


namespace Modules\incredibleOffers;


use App\BaseModule;
use Modules\incredibleOffers\Repository\IncredibleOffersRepositoryInterface;

class Module extends BaseModule
{

    protected $widget_id=null;

    public function discount_create_form(){
        return [
            'after_amount_percent'=>'incredibleOffers::check-box',
        ];
    }

    public function discount_edit_form(){
        return [
            'after_amount_percent'=>'incredibleOffers::check-box',
        ];
    }

    public function discount_codes_saving($model){
        $model->incredible_offers=array_key_exists('incredible_offers',$_POST) ? 1 : 0;
    }

    public function check_has_discount($discount,$variation){

    }

    public function price_variation_index_right_click(){
        if(\Auth::check()){
            return [
                'items'=>[
                    'label'=>'ثبت به عنوان پیشنهاد شگفت انگیز',
                    'url'=>'product/incredible-offers/:id/add'
                ]
            ];
        }
    }

    public function widgets(){
        $settings=[
            'list'=>[
                'cat1'=>['type'=>'string','value'=>'','label'=>'نمایش محصولات دسته  '],
                'cat2'=>['type'=>'string','value'=>'','label'=>'عدم نمایش محصولات دسته  '],
             ],
            'data'=>[]
        ];
        return [
            [
                'name'=>'incredibleOffers',
                'title'=>'پیشنهادات شگفت انگیز',
                'view'=>'incredibleOffers::front.product_list',
                'setting'=>$settings
            ]
        ];
    }

    public function incredibleOffers_widget($args,$data){
        $cat1=0;
        $cat2=0;

        if(array_key_exists('cat1',$data) && !empty($data['cat1'])){
            $cat1=$data['cat1'];
        }
        if(array_key_exists('cat2',$data) && !empty($data['cat2'])){
            $cat2=$data['cat2'];
        }

        $repository=app(IncredibleOffersRepositoryInterface::class);
        $products=$repository->lastOffers($cat1,$cat2);

        $this->widget_id=$data['data_id'];
        $key=str_replace('-','_',$data['data_id']);
        $args[$key]=[
            'products'=>$products
        ];
        return $args;
    }

    public function registerComponent(){
        if(!request()->is('admin/*')){
            return vue_component_detail('incredibleOffers');
        }
    }

    public function begin_search_product_box()
    {
        return [
            [
                'view'=>'incredibleOffers::product.timer',
                'index'=>0,
            ]
        ];
    }

    public function before_shop_variation_detail(){
        return [
            [
                'view'=>'incredibleOffers::product.page_counter',
                'index'=>0,
            ]
        ];
    }
}
