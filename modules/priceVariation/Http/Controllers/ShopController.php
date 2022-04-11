<?php


namespace Modules\priceVariation\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\priceVariation\Repository\PriceVariationRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;

class ShopController extends Controller
{
    public function change_product_variation(Request $request,PriceVariationRepositoryInterface $repository,ProductRepositoryInterface $productRepository){
        $product_id=$request->get('product_id');
        $product=$productRepository->findWithWhere(['id'=>$product_id],['PriceVariation']);
        $param1=$request->get('param1');
        $param2=$request->get('param2');
        $change_num=$request->get('change_num');
        if($product){
            $price_variation=$repository->setVariation($param1,$param2,$product_id);
            $data=['product'=>$product];
            if($price_variation){
                $data['price_variation']=$price_variation;
            }
            else{
                $p1=($change_num==="1") ? $param1 : null;
                $p2=($change_num==="2") ? $param2 : null;
                $price_variation=$repository->setVariation($p1,$p2,$product_id);
                if($price_variation){
                    $data['price_variation']=$price_variation;
                }
            }
            $paramsView=view('priceVariation::product.params-view',$data)->render();
            $detailView=view('priceVariation::product.detail-view',$data)->render();
            return  [
                'paramsView'=>$paramsView,
                'detailView'=>$detailView
            ];
        }
        else{
            return  [];
        }
    }

    public function getAppProductVariation($product_id,Request $request,PriceVariationRepositoryInterface $repository,
            ProductRepositoryInterface $productRepository){

        $product=$productRepository->first(['id'=>$product_id],[],['id']);
        if($product){
            $param1_id=$request->get('param1_id');
            $param1_id=$param1_id=="null" ? null : $param1_id;
            return  $repository->productVariations(
                ['product_id'=>$product_id,'param1_id'=>$param1_id],
                ['param1','param2']
            );
        }
        else{
            return [];
        }
    }
}

