<?php


namespace Modules\questions\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\questions\Models\Question;
use Auth;
use DB;
class EloquentQuestionRepository extends EloquentBaseRepository implements QuestionRepositoryInterface
{
    protected $model="Modules\questions\Models\Question";


    public function find($id)
    {
        return Question::where(['id'=>$id,'question_id'=>0])->firstOrFail();
    }

    public function create($request)
    {
        $send_email=$request->get('send_email')=="true" ? 'ok' : 'no';
        $user_id=$request->user()->id;
        $Question=new Question($request->all());
        $Question->time=time();
        $Question->user_id=$user_id;
        $Question->send_email=$send_email;
        $Question->save();
    }

    public function trashCount()
    {
        return Question::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Question::getData($request->all());
    }

    public function update($id, $request)
    {

    }

    public function change_status($request)
    {
        $result='error';
        $question_id = $request->get('question_id');
        $question = Question::find($question_id);
        if ($question) {
            $status=$question->status==1 ? 0 : 1;
            $question->status=$status;
            if($question->update())
            {
                if($question->question_id>0)
                {
                    Question::updateAnswerCount($question->question_id,$status);
                }
                if($question->question_id>0 &&  $status==1)
                {
                    Question::sendAnswerEmail($question);
                }
                $result='ok';
            }
        }
        return $result;
    }

    public function answer($request, $id, $answer_text)
    {
        $user_id=$request->user()->id;
        $question=$this->find($id);
        $question->answer_count=($question->answer_count+1);
        $question->update();

        $answer=new Question();
        $answer->time=time();
        $answer->user_id=$user_id;
        $answer->status=1;
        $answer->question_id=$id;
        $answer->question=$answer_text;
        $answer->product_id=$question->product_id;
        $answer->save();

        Question::sendAnswerEmail($answer);
    }

    public function product_questions($product_id,$request)
    {
        $ordering=$request->get('ordering','new');
        $relations=CompleteData('question_relations',['answer']);
        $Question=Question::with($relations)
            ->where(['question_id'=>0,'product_id'=>$product_id,'status'=>1]);

        if($ordering=='new')
        {
            $Question=$Question->orderBy('id','DESC');
        }
        else if($ordering=='answer_count')
        {
            $Question=$Question->orderBy('answer_count','DESC');
        }
        else if($ordering=='user' && Auth::check())
        {
            $user_id=$request->user()->id;
            $Question=$Question->orderByRaw(\DB::raw("FIELD(user_id,".$user_id.") DESC"));
        }
        else{
            $Question=$Question->orderBy('id','DESC');
        }

        $Question=$Question->paginate(10);

        return $Question;
    }

    public function count($where)
    {
       return Question::where($where)->count();
    }

    public function first($where)
    {
        return Question::where($where)->first();
    }

    public function score_status($where)
    {
        return DB::table('question_score')
            ->where($where)
            ->first();
    }

    public function remove_score($where)
    {
        DB::table('question_score')
            ->where($where)
            ->delete();
    }

    public function add_score($data)
    {
        DB::table('question_score')->insert($data);
    }

    public function update_comment_score($id,$data){
        Question::where([
            'id'=>$id
        ])->update($data);
    }
}
