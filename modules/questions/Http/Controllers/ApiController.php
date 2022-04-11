<?php


namespace Modules\questions\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\questions\Models\Question;

class ApiController extends Controller
{
    public function lastQuestion($product_id){

        $response=[];

        $question_count=Question::where(['product_id'=>$product_id,'status'=>1,'question_id'=>0])
            ->count();

        $questions=Question::with('user')
            ->where(['product_id'=>$product_id,'status'=>1,'question_id'=>0])
            ->orderBy('id','DESC')
            ->limit(2)
            ->get();

        $response['questions']=$questions;
        $response['question_count']=$question_count;

        return $response;
    }
}
