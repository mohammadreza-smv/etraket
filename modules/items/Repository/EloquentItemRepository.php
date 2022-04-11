<?php


namespace Modules\items\Repository;

use Modules\categories\Models\Category;
use Modules\categories\Repository\CategoryRepositoryInterface;
use Modules\items\Models\Item;
use Modules\items\Models\ItemValue;

class EloquentItemRepository  implements ItemRepositoryInterface
{
    public function item($id)
    {
        return Item::with('getChild')
            ->where(['category_id'=>$id,'parent_id'=>0])
            ->orderBy('position','ASC')->get();
    }
    public function find($id)
    {
        return Item::findOrFail($id);
    }
    public function destroy($item)
    {
        $item->getChild()->delete();
        $item->delete();
    }
    public function addItem($catId,$request){
        $items=$request->get('item',array());
        $child_item=$request->get('child_item',array());
        $checked_item=$request->get('check_box_item',array());
        Item::addItem($items,$child_item,$checked_item,$catId);
    }

    public function catItem($catId)
    {
        $categoryRepository=app(CategoryRepositoryInterface::class);
        $category=$categoryRepository->onlyFind($catId);
        $cat_id[0]=$catId;
        if($category){
            $cat_id[1]=$category->parent_id;
        }
        $items=Item::with('getChild')->where(['parent_id'=>0])
            ->whereIn('category_id',$cat_id)
            ->orderBy('position','ASC')->get();
        return $items;
    }

    public function getProductItem($data)
    {
        return Item::getProductItem($data);
    }

    public function productItemCount($product_id)
    {
        return ItemValue::where('product_id',$product_id)->count();
    }

    public function product_items($product)
    {
        define('product_id',$product->id);
        $category=Category::find($product->cat_id);
        $cat_id[0]=$product->cat_id;
        if($category){
            $cat_id[1]=$category->parent_id;
        }
        $items=Item::with('getChild.getValue')
            ->where(['parent_id'=>0])
            ->whereIn('category_id',$cat_id)
            ->orderBy('position','ASC')->get();
        return $items;
    }

    public function add_product_items($product, $request)
    {
        $item_value=$request->get('item_value');
        ItemValue::where(['product_id'=>$product->id])->delete();
        foreach ($item_value as $key=>$value)
        {
            foreach ($value as $key2=>$value2)
            {
                if(!empty($value2)){
                    ItemValue::create([
                        'product_id'=>$product->id,
                        'item_id'=>$key,
                        'item_value'=>$value2
                    ]);
                }
            }
        }

        run_action('after_created_product_items',[$product,$request]);
    }
}
