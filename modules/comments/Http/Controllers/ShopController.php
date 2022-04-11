<?php


namespace Modules\comments\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\comments\Repository\CommentRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;

class ShopController extends Controller
{
    public function comment_form($product_id,ProductRepositoryInterface $productRepository)
    {
        $product=$productRepository->find($product_id);
        return CView('comments::'.$this->view.'comment_form',['product'=>$product]);
    }

    public function add_comment($product_id,Request $request,ProductRepositoryInterface $productRepository,CommentRepositoryInterface $commentRepository)
    {
        $product=$productRepository->find($product_id);
        $status=$commentRepository->add_comment($request,$product);
        return  [
            'status'=>'ok',
            'message'=>'ثبت نظر با موفقیت انجام شد و بعد از تایید نمایش داده خواهد شد'
        ];
    }

    public function comments(Request $request,CommentRepositoryInterface $commentRepository)
    {
        $user_id = $request->user()->id;
        $comments=$commentRepository->user_comments($user_id);
        return CView('comments::'.$this->view . 'user_comments',['comments'=>$comments]);
    }

    public function set_score($type,Request $request,CommentRepositoryInterface $repository){

        $row_id=$request->get('row_id','');
        $comment=$repository->first(['id'=>$row_id]);
        $u='error';
        if($comment){

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
            $u['like']= $comment->like;
            $u['dislike']=$comment->dislike;

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
