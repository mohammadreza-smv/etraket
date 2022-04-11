<?php

namespace themes\theme1;
use App\BaseModule;
use Modules\questions\Models\Question;

class Module extends BaseModule
{
    protected function set_questions_data($data,$response){

        $product_id=$data['product']->id;

        $question_count=Question::where(['product_id'=>$product_id,'status'=>1,'question_id'=>0])
            ->count();

        $questions=Question::with('user')
            ->where(['product_id'=>$product_id,'status'=>1,'question_id'=>0])
            ->orderBy('id','DESC')
            ->limit(2)
            ->get();

        $response['questions']=$questions;
        $response['question_count']=$question_count;

        return $response;
    }

    public function widget_location(): array
    {
        return [
            'desktop_every_page'=>[
                'title'=>'هدر فروشگاه در قالب دسکتاپ',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در ابتدای تمام صفحات فروشگاه',
            ],
            'desktop_home_content'=>[
                'title'=>'صفحه اصلی قالب دسکتاپ',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در صفحه اصلی فروشگاه',
            ],
            'mobile_home_content'=>[
                'title'=>'صفحه اصلی قالب موبایل',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در صفحه اصلی فروشگاه',
            ],
            'desktop_show_product'=>[
                'title'=>'صفحه جزییات محصول قالب دسکتاپ',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در صفحه جزییات محصول',
            ],
            'mobile_show_product'=>[
                'title'=>'صفحه جزییات محصول قالب موبایل',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در صفحه جزییات محصول در قالب موبایل',
            ],
            'desktop_layout_footer'=>[
                'title'=>'پاورقی در قالب دسکتاپ',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در فوتر قالب دستکاپ',
            ],
            'mobile_layout_footer'=>[
                'title'=>'پاورقی در قالب موبایل',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در فوتر قالب موبایل',
            ],
            'desktop_main_cat'=>[
                'title'=>'صفحه دسته های اصلی در قالب دسکتاپ',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در صفحه دسته های اصلی در قالب دستکاپ',
                'positionParam'=>'شناسه دسته'
            ]
        ];
    }

    public function widgets(){
        $horizontal_product_list=get_horizontal_product_list_setting();
        return [
            [
                'name'=>'horizontal_product_list',
                'title'=>'لیست محصولات',
                'setting'=>$horizontal_product_list,
                'view'=>'horizontal_product_list'
            ]
        ];
    }

    public function horizontal_product_list_widget($args,$data){
        if(class_exists(\Modules\products\Models\Product::class)){
            $key=str_replace('-','_',$data['data_id']);
            $title=array_key_exists('title',$data) ? $data['title'] :'';
            if(!array_key_exists('load_type',$data) || $data['load_type']==0){
                $productList=new ProductList($data,$args);
                $products=$productList->data();
                $args[$key]=[
                    'products'=>$products,
                    'title'=>$title,
                ];
            }
            else{
                $args[$key]=[
                    'title'=>$title,
                    'products'=>[],
                    'load_type'=>$data['load_type'],
                    'data'=>$data
                ];
            }
        }
        return $args;
    }

    public function exception(){
        getCatList();
    }

    public function registerComponent($theme,$type){
        if(!request()->is('admin/*')){
            return vue_component_detail('shop');
        }
    }

    public function set_layout_data($layout){
        if(str_contains($layout,'theme1/layouts')){
            getCatList();
        }
    }
}
