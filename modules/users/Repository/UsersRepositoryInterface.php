<?php


namespace Modules\users\Repository;


use App\Repositories\BaseInterface;

interface UsersRepositoryInterface extends BaseInterface
{
    public function first($where);

    public function get_user_register_detail($user_id);

    public function add_register_detail($user,$data);
}
