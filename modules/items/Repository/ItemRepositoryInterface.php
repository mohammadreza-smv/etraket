<?php


namespace Modules\items\Repository;


use App\Repositories\BaseInterface;
use Modules\categories\Repository\CategoryRepositoryInterface;

interface ItemRepositoryInterface
{
    public function item($id);

    public function find($id);

    public function destroy($item);

    public function addItem($catId,$request);

    public function catItem($cat_id);

    public function getProductItem($data);

    public function productItemCount($product_id);

    public function product_items($product);

    public function add_product_items($product,$request);
}
