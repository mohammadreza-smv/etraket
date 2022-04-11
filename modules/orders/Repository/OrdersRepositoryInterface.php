<?php


namespace Modules\orders\Repository;


use App\Repositories\BaseInterface;

interface OrdersRepositoryInterface extends BaseInterface
{
    public function add_order($user_id,$send_order_data);

    public function change_submission_state($request);

    public function submission($request,$status,$order);

    public function trashSubmissionCount($status);

    public function userLastOrder($where);

    public function userOrder($where);

    public function globalOrderData($where);

    public function ordersWithSendStatus($status,$where);
}
