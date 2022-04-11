<?php


namespace Modules\productComparison\Repository;

use Modules\catBrands\Models\CatBrand;
use Modules\categories\Models\Category;
use Modules\items\Models\Item;
use Modules\products\Models\Product;

class EloquentProductComparisonRepository implements ProductComparisonRepositoryInterface
{

    public function products($ids)
    {
        return Product::with(['itemValue','Gallery'])
            ->whereIn('id',$ids)
            ->select(['id','title','cat_id','price','product_url','image_url'])->get();
    }

    public function getCategory($id)
    {
        return Category::where('id',$id)->firstOrFail();
    }

    public function getItemsForCategory($category)
    {
        $cat_id[0]=$category->id;
        if($category){
            $cat_id[1]=$category->parent_id;
        }
        return Item::with('getChild')
            ->where(['parent_id'=>0])
            ->whereIn('category_id',$cat_id)
            ->orderBy('position','ASC')->get();
    }

    public function getSearchBrand($request)
    {
        $cat_id=$request->get('cat_id',0);
        return CatBrand::with('getBrand')->where('cat_id',$cat_id)->get();

    }

    public function getProductForComparison($request)
    {
        $brand_id=$request->get('brand_id',0);
        $cat_id=$request->get('cat_id',0);
        $search_text=$request->get('search_text');

        $products=Product::where('cat_id',$cat_id)->select(['id','price','image_url','title']);

        if($brand_id>0){
            $products=$products->where('brand_id',$brand_id);
        }
        if($search_text){
            $products=$products->where('title','like','%'.$search_text.'%');
        }
        $products=$products->orderBy('order_number','DESC')->paginate(10);

        return $products;
    }
}
