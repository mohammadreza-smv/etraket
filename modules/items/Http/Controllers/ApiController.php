<?php


namespace Modules\items\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\items\Repository\ItemRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;

class ApiController extends Controller
{
    public function items($id,ProductRepositoryInterface $productRepository, ItemRepositoryInterface $itemRepository)
    {
        $product=$productRepository->find($id);
        $productItemCount=$itemRepository->productItemCount($id);
        if($product && $productItemCount>0){
            return  $itemRepository->product_items($product);
        }
        else{
            return [];
        }
    }
}
