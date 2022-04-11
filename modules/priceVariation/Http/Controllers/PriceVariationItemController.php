<?php

namespace Modules\priceVariation\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\categories\Repository\CategoryRepositoryInterface;
use Modules\priceVariation\Repository\VariationItemsInterface;

class PriceVariationItemController extends Controller
{
    public function priceVariationItems($id,CategoryRepositoryInterface $categoryRepository,VariationItemsInterface $variationItems)
    {
        $category=$categoryRepository->find($id);
        $items=CompleteData('price_variation_item',
            [''=>'انتخاب معیار','Modules\priceVariation\Module'=>'مقادیر دلخواه']);
        $priceVariationParam=$variationItems->params($id);
        return CView('priceVariation::items',compact('category','items','priceVariationParam'));
    }

    public function add_price_variation($cat_id,Request $request,VariationItemsInterface $repository)
    {
        $repository->addItems($cat_id,$request->all());

        return  [
            'redirect_url'=>url('admin/category/'.$cat_id.'/price_variation'),
            'message'=>'ثبت معیار تعیین هزینه با موفقیت انجام شد'
        ];
    }

    public function destroy($id,VariationItemsInterface $repository)
    {
        $url=\URL::previous();
        $check=$repository->find($id);
        if(!$check){
            return  [
                'status'=>'error',
                'message'=>'حذف معیار تعیین هزینه با موفقیت انجام شد'
            ];
        }
        else{
            $repository->destroy($id);
            return  [
                'redirect_url'=>$url,
                'message'=>'حذف معیار تعیین هزینه با موفقیت انجام شد'
            ];
        }
    }
}
