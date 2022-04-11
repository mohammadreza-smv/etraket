<?php


namespace Modules\questions\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\questions\Repository\QuestionRepositoryInterface;

class ShopController extends Controller
{
    public function get_question($product_id,Request $request,QuestionRepositoryInterface $repository){
        return $repository->product_questions($product_id,$request);
    }

    public function addQuestion(Request $request,QuestionRepositoryInterface $repository){
        $repository->create($request);
        return 'ok';
    }

    public function set_score($type,Request $request,QuestionRepositoryInterface $repository){

        $row_id=$request->get('row_id','');
        $question=$repository->first(['id'=>$row_id]);

        $u='error';

        if($question){

            $user_id=$request->user()->id;

            $like_status=$repository->score_status([
                'user_id'=>$user_id,
                'row_id'=>$row_id,
                'type'=>'like',
            ]);
            $dislike_status=$repository->score_status([
                'user_id'=>$user_id,
                'row_id'=>$row_id,
                'type'=>'dislike',
            ]);

            $u=[];
            $u['like']= $question->like;
            $u['dislike']=$question->dislike;

            if($like_status){
                $u['like']= $u['like']-1;
                $repository->remove_score(['user_id'=>$user_id, 'row_id'=>$row_id, 'type'=>'like',]);
            }
            if($dislike_status){
                $u['dislike']= $u['dislike']-1;
                $repository->remove_score(['user_id'=>$user_id, 'row_id'=>$row_id, 'type'=>'dislike',]);
            }

            if($type=='like' && !$like_status){
                $u['like']=$u['like']+1;
                $repository->add_score(['user_id'=>$user_id, 'row_id'=>$row_id, 'type'=>$type]);
            }
            else if($type=='dislike' && !$dislike_status){
                $u['dislike']=$u['dislike']+1;
                $repository->add_score(['user_id'=>$user_id, 'row_id'=>$row_id, 'type'=>$type]);
            }

            $repository->update_comment_score($row_id,$u);
        }

        return  $u;
    }
}
