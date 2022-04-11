<?php


namespace themes\theme1;


use Modules\categories\Models\Category;
use Modules\products\Models\Product;

class ProductList
{
    protected $catId=null;

    protected $routeData;

    protected $notId=0;

    protected $widgetSetting=null;

    public function __construct($data,$routeData=[])
    {
        if(array_key_exists('catList',$data)){
            if($data['catList']!=''){
                $cat_id= ($data['catList']==':id') ? cat_id : $data['catList'];
                $this->catId=$cat_id;
            }
        }
        $this->widgetSetting=$data;
        $this->routeData=$routeData;
        $this->productsDetail();
    }

    public function data(){

        $products=Product::where('status',1)
            ->whereHas('FirstPriceVariation')->select(
                ['id','cat_id','product_url','price','image_url','title','discount_price']
            );
        if($this->catId){
            $catsId=$this->getCatList($this->catId);
            $products=$products->whereIn('cat_id',$catsId);
        }
        if($this->notId>0){
            $products=$products->where('id','!=',$this->notId);
        }
        $products=CompleteData('product_list_query',$products);

        return $products->orderBy('id','DESC')
            ->orderBy('view','DESC')->limit(10)->get();
    }

    protected function getCatList($catId){
        $array=[];
        $category=Category::where('id',$catId)->with('getChild.getChild.getChild')->first();
        if($category){
            $array[]=$catId;

            foreach ($category->getChild as $key1=>$child1){
                $array[]=$child1->id;

                foreach ($child1->getChild as $key2=>$child2){
                    $array[]=$child2->id;

                    foreach ($child2->getChild as $key3=>$child3){
                        $array[]=$child3->id;
                    }
                }
            }
        }
        return $array;
    }

    protected function productsDetail(){
        if(is_array($this->widgetSetting) && array_key_exists('product_type',$this->widgetSetting)){
            if($this->widgetSetting['product_type']==3  && is_array($this->routeData) && array_key_exists('product',$this->routeData)){
                $this->catId=$this->routeData['product']->cat_id;
                $this->notId=$this->routeData['product']->id;
            }
        }
    }
}
