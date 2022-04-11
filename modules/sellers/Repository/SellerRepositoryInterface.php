<?php


namespace Modules\sellers\Repository;


use App\Repositories\BaseInterface;

interface SellerRepositoryInterface extends BaseInterface
{
    public function firstOrFail($id);

    public function products($seller_id);

    public function documents($seller_id);

    public function export();

    public function get_all_payment();

    public function add_payment($data);

    public function payments($request);

    public function sellers();

    public function addProduct($id,$model);

    public function panel_product_list($request);

    public function total_product($request);

    public function remove_product();

    public function findProductForEdit($id);

    public function add_seller_sale($data);

    public function get_seller_sale_statistics($seller_id,$year,$now_year);

    public function getProductsId($seller_id);

    public function brandsUsed($seller_id);

    public function categoriesUsed($seller_id);

    public function checkUserFollow($seller_id);

    public function follow($request);

    public function followers_count($seller_id);

    public function lastProducts($seller_id);

    public function getLastFollowedProduct($user_id);
}
