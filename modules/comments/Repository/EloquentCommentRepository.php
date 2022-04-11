<?php


namespace Modules\comments\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\comments\Models\AddComment;
use Modules\comments\Models\Comment;
use DB;
use Modules\comments\Models\CommentScore;

class EloquentCommentRepository extends EloquentBaseRepository implements CommentRepositoryInterface
{
    protected $model='Modules\comments\Models\Comment';

    public function find($id)
    {

    }

    public function create($request)
    {

    }

    public function add_comment($request,$product)
    {
        $addComment=new AddComment($request,$product);
        return $addComment->create();
    }

    public function trashCount()
    {
        return Comment::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Comment::getData($request->all());
    }

    public function update($id, $request)
    {
        $result='error';
        $comment_id=$request->get('comment_id');
        $comment=Comment::find($comment_id);
        if($comment){
            $status=$comment->status==1 ? 0 : 1;
            $comment->status=$status;
            DB::table('comment_scores')->where('comment_id',$comment->id)->update(['status'=>$status]);
            if($comment->update())
            {
                $result='ok';
            }
        }
        return  $result;
    }

    public function product_comments($request)
    {
        $product_id=$request->get('product_id',0);
        $orderBy=$request->get('orderBy',1);

        $array=array();
        $n=CommentScore::where(['product_id'=>$product_id,'status'=>1])->count();
        $sum1=CommentScore::where(['product_id'=>$product_id,'status'=>1])->sum('score1');
        $sum2=CommentScore::where(['product_id'=>$product_id,'status'=>1])->sum('score2');
        $sum3=CommentScore::where(['product_id'=>$product_id,'status'=>1])->sum('score3');
        $sum4=CommentScore::where(['product_id'=>$product_id,'status'=>1])->sum('score4');
        $sum5=CommentScore::where(['product_id'=>$product_id,'status'=>1])->sum('score5');
        $sum6=CommentScore::where(['product_id'=>$product_id,'status'=>1])->sum('score6');

        if($n>0)
        {
            $sum1=$sum1/$n;
            $sum2=$sum2/$n;
            $sum3=$sum3/$n;
            $sum4=$sum4/$n;
            $sum5=$sum5/$n;
            $sum6=$sum6/$n;
        }

        $relations=CompleteData('get_product_comments_relations',['getScore']);
        $comments=Comment::with($relations)->whereHas('getScore')
            ->where(['product_id'=>$product_id,'status'=>1]);

        if($orderBy==1)
        {
            $comments=$comments->orderBy('order_id','DESC');
        }
        else if($orderBy==2){
            $comments=$comments->orderBy('like','DESC');
        }
        else if($orderBy==3){
            $comments=$comments->orderBy('id','DESC');
        }

        $comments=$comments->paginate(10);
        $array['comment']=$comments;
        $avg=$sum1+$sum2+$sum3+$sum4+$sum5+$sum6;
        $avg=$avg/6;
        $array['avg']=round($avg);
        $array['comment_count']=$n;
        $array['avg_score']=[$sum1,$sum2,$sum3,$sum4,$sum5,$sum6];

        return $array;
    }

    public function count($where){
        return Comment::where($where)->count();
    }

    public function user_comments($user_id)
    {
       $relations=CompleteData('show_user_comments_relations',['getScore']);
       return Comment::where('user_id',$user_id)
           ->orderBy('id','DESC')->with($relations)
           ->paginate(10);
    }

    public function first($where)
    {
        return Comment::where($where)->first();
    }

    public function score_status($where)
    {
        return DB::table('comment_score')
            ->where($where)
            ->first();
    }

    public function remove_score($where)
    {
        DB::table('comment_score')
            ->where($where)
            ->delete();
    }

    public function add_score($data)
    {
        DB::table('comment_score')->insert($data);
    }

    public function update_comment_score($id,$data){
        Comment::where([
            'id'=>$id
        ])->update($data);
    }
}
