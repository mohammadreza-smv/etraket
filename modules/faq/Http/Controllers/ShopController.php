<?php


namespace Modules\faq\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\faq\Repository\CategoryRepositoryInterface;
use Modules\faq\Repository\QuestionRepositoryInterface;

class ShopController  extends Controller
{
    protected $categoryRepository;

    protected $questionRepository;

    public function __construct(Request $request,CategoryRepositoryInterface $categoryRepository,QuestionRepositoryInterface $questionRepository)
    {
        $this->categoryRepository=$categoryRepository;
        $this->questionRepository=$questionRepository;
        parent::__construct($request);
    }

    public function faq(Request $request){
        $search_question=[];
        $cat=$this->categoryRepository->all();
        $question=$this->questionRepository->get(['pin'=>1]);
        $q=$request->get('q');
        if(!empty($q)){
            $search_question=$this->questionRepository->search('title',$q);
        }
        return CView('faq::'.$this->view . 'faq',['cat'=>$cat,'question'=> $question,'search_question'=>$search_question,'q'=>$q,'request'=>$request]);
    }

    public function faq_category($id){
        $cat=$this->categoryRepository->find($id);
        $question=$this->questionRepository->get(['cat_id'=>$id]);
        $pin_question=$this->questionRepository->get(['pin'=>1]);
        return CView('faq::'.$this->view . 'faq_category',['cat'=>$cat,'pin_question'=> $pin_question,'question'=>$question]);
    }

    public function faq_question($id){
        $question=$this->questionRepository->find($id);
        $pin_question=$this->questionRepository->get(['pin'=>1]);
        return CView('faq::'.$this->view . 'faq_question',['pin_question'=> $pin_question,'question'=>$question]);
    }
}
