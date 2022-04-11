<?php


namespace Modules\api\Repository;


use Modules\categories\Models\Category;
use Modules\priceVariation\Models\PriceVariation;
use Modules\products\Models\Product;

class EloquentApiRepository implements ApiRepositoryInterface
{
    public function product_list($request)
    {
        $order=$request->get('order','id');
        $catId=$request->get('catId',0);
        $products=Product::where('status',1)
            ->whereHas('firstProductPrice')
            ->orderBy($order,'DESC')
            ->select(['id','order_number','title','price','image_url']);
        if($catId>0){
            $products->where('cat_id',$catId);
        }
        $products=$products->limit(12)->get();

        return $products;
    }

    public function categories()
    {
        return Category::select(['id','name'])
            ->with('getChild')
            ->where('parent_id',0)->get();
    }

    public function child_categories($catId)
    {
        return Category::select(['id','name','img'])->where('parent_id',$catId)->get();
    }

    public function catProduct($catId,$order){
        $cat=Category::where('parent_id',$catId)->pluck('id','id')->toArray();
        $cat[$catId]=$catId;
        return Product::where(['status'=>1])
            ->whereIn('cat_id',$cat)
            ->whereHas('firstProductPrice')
            ->orderBy($order,'DESC')
            ->select(['id','order_number','title','price','image_url'])
            ->limit(12)->get();
    }

    public function incredible_offers()
    {
        $now=get_incredible_offers_start_time();
        $incredible_offers=PriceVariation::with('product')
            ->where('offers_first_time','<=',$now)
            ->whereHas('product')
            ->where(['offers'=>1])
            ->limit(10)->inRandomOrder()
            ->get()->unique('product_id');

        return $incredible_offers;
    }
}
