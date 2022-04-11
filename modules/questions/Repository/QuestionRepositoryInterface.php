<?php


namespace Modules\questions\Repository;


use App\Repositories\BaseInterface;

interface QuestionRepositoryInterface extends BaseInterface
{
    public function change_status($request);

    public function answer($request,$id,$answer);

    public function product_questions($product_id,$request);

    public function count($where);

    public function first($where);

    public function score_status($where);

    public function remove_score($where);

    public function add_score($data);

    public function update_comment_score($id,$data);
}
