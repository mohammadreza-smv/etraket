<?php

namespace Modules\questions;

use App\BaseModule;
use Modules\products\Models\Product;
use Modules\questions\Repository\QuestionRepositoryInterface;
use Modules\users\Models\AdditionalInfo;
use Auth;
use View;

class Module extends BaseModule
{
    public function product_question_relations($relation){
        if(class_exists('Modules\products\Models\Product')){
            $relation[]='product';
        }
        if(class_exists('Modules\users\Models\AdditionalInfo')){
            $relation[]='user';
        }
        return $relation;
    }

    public function questions_product_relation(){
        return function($self){
           return $self->hasone(Product::class,'id','product_id')
               ->select(['id','product_url','title']);
        };
    }

    public function questions_user_relation(){
        return function($self){
            return $self->hasone(AdditionalInfo::class,'user_id','user_id')
                ->select(['id','user_id','email','first_name','last_name']);
        };
    }

    public function question_relations($relation){
        if(class_exists('Modules\users\Models\AdditionalInfo')){
            $relation[0]=$relation[0].'.user';
            $relation[]='user';
        }
        return $relation;
    }

    public function load_backend_data(){
        if(Auth::user()->role=='admin' || has_access_author_admin('questions')){
            $repository=app(QuestionRepositoryInterface::class);
            $question_count=$repository->count(['status'=>0]);
            View::share('question_count',$question_count);
        }
    }

    public function set_user_access_list($access){
        $access['questions']=[
            'label'=>'پرسش ها و پاسخ های کاربران ',
            'access'=>[
                'question_manager'=>['label'=>'مدیریت پرسش ها و پاسخ های کاربران ',
                    'routes'=>['questions.index','change_question_status','questions.destroy','questions.restore','questions_addAnswer']],
            ]
        ];
        return $access;
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName==='show_product' || $routeName==='questions_index'){
            return vue_component_detail('questions');
        }
    }

    public function mobile_product_view(): array
    {
        return [
            [
                'view'=>'questions::mobile.question_list',
                'index'=>2
            ]
        ];
    }
}
