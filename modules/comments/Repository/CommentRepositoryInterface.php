<?php


namespace Modules\comments\Repository;


use App\Repositories\BaseInterface;

interface CommentRepositoryInterface extends BaseInterface
{
    public function product_comments($request);

    public function add_comment($request,$product);

    public function count($where);

    public function user_comments($user_id);

    public function first($where);

    public function score_status($where);

    public function remove_score($where);

    public function add_score($data);

    public function update_comment_score($id,$data);
}
