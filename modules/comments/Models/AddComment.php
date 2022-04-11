<?php


namespace Modules\comments\Models;
use DB;
use function PHPUnit\Framework\isJson;

class AddComment
{
    protected $product;
    protected $request;
    protected $comment;
    public function __construct($request,$product)
    {
        $time=time();
        $this->comment=new Comment($request->all());
        $this->comment->user_id=$request->user()->id;

        $advantage=$request->get('advantage',array());
        $disadvantage=$request->get('disadvantage',array());
        if(is_string($advantage)){
            $advantage=json_decode($advantage);
            $disadvantage=json_decode($disadvantage);
        }

        $this->comment->advantage=$this->getCommentItem($advantage);
        $this->comment->disadvantage=$this->getCommentItem($disadvantage);

        $this->comment->product_id=$product->id;
        $this->comment->time=$time;
        $this->comment->status=0;
        $this->product=$product;
        $this->request=$request;
//        $order_id=getCommentOrderId($product->id,$user_id);
    }

    public function create(){
        DB::beginTransaction();

        try {
            $this->comment->saveOrFail();
            $this->addScore();
            DB::commit();
            return [
                'status'=>'ok',
            ];
        }
        catch (\Exception $exception)
        {
            return [
                'status'=>'error',
            ];
        }
    }

    protected function getCommentItem($array)
    {
        $string='';
        foreach ($array as $key=>$value)
        {
            $string.=$value.'|[@#]|';
        }
        return $string;
    }

    protected function addScore(){
        $score=0;
        $array_score=$this->request->get('score_item',array());
        if(is_string($array_score)){
            $array_score=json_decode($array_score);
        }
        if(sizeof($array_score)==6){
            $score=$array_score[0]+$array_score[1]+$array_score[2]+$array_score[3]+$array_score[4]+$array_score[5];
        }
        $this->product->score= $this->product->score+$score;
        $this->product->score_count= $this->product->score_count+1;
        $this->product->update();


        if(sizeof($array_score)==6)
        {
            $commentScore=new CommentScore();
            $commentScore->product_id=$this->product->id;
            $commentScore->comment_id=$this->comment->id;
            $commentScore->score1=$array_score[0];
            $commentScore->score2=$array_score[1];
            $commentScore->score3=$array_score[2];
            $commentScore->score4=$array_score[3];
            $commentScore->score5=$array_score[4];
            $commentScore->score6=$array_score[5];
            $commentScore->save();
        }
    }
}
