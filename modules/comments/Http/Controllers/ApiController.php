<?php


namespace Modules\comments\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\comments\Models\Comment;
use Modules\comments\Repository\CommentRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;

class ApiController extends Controller
{
    public function create(Request $request,ProductRepositoryInterface $productRepository,CommentRepositoryInterface $commentRepository){

        $product_id=$request->get('product_id');
        $product=$productRepository->first(['id'=>$product_id]);
        if($product){
            $status=$commentRepository->add_comment($request,$product);
            return  'ok';
        }
        else{
            return 'error';
        }
    }

    public function comments(Request $request,CommentRepositoryInterface $commentRepository){
        return $commentRepository->product_comments($request);
    }

    public function userCreate(Request $request,CommentRepositoryInterface $commentRepository){
        $user_id=$request->user()->id;
        $result=$commentRepository->user_comments($user_id);
        return ['comment'=>$result];
    }

    public function lastComments($product_id)
    {
        $comment_count=Comment::where(['product_id'=>$product_id,'status'=>1])->count();

        $useful_comment=Comment::with('user')
            ->where(['product_id'=>$product_id,'status'=>1])
            ->orderBy('like','DESC')
            ->limit(2)->get();

        $response['comment_count']=$comment_count;
        $response['useful_comment']=$useful_comment;

        return $response;
    }
}
