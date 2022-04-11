<?php


namespace Modules\salesReport\Repository;

interface SaleRepositoryInterface
{
    public function set_province_order_count($order_id);

    public function set_order_sale($order_id);
}
