<?php


namespace Modules\orders\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\orders\Repository\SubmissionRepositoryInterface;

class SubmissionController extends CustomController
{
    protected $title='مرسوله ';

    protected $route_params='orders/submissions';

    protected $repository;

    public function __construct(SubmissionRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request,SubmissionRepositoryInterface $submissionRepository){
        $submissions=$this->repository->submission($request->all(),0,'DESC');
        $trash_submission_count=$this->repository->trashSubmissionCount('');
        return CView('orders::submissions',[
            'label'=>'مدیریت مرسوله ها' ,
            'label_url'=>'submissions',
            'submissions'=>$submissions,
            'req'=>$request,
            'trash_submission_count'=>$trash_submission_count
        ]);
    }

    public function show($id){
        $submission=$this->repository->find($id);
        $submission=[$submission];
        return CView('orders::submission-show',compact('submission'));
    }

    public function submissions(Request $request){
        $page_url=$request->url();
        $url=url('admin/orders/submissions/send_type/');
        $key=str_replace($url,'',$page_url);
        $key=str_replace("/",'',$key);

        $orderStatus=\Modules\orders\Models\Orders::OrderStatus();
        if(array_key_exists($key,$orderStatus)){
            $submissions=$this->repository->submission($request->all(),$key,'DESC');
            $trash_submission_count=$this->repository->trashSubmissionCount($key);
            return CView('orders::submissions',[
                'label'=>getOrderStatus($key) ,
                'label_url'=>'submissions',
                'submissions'=>$submissions,
                'req'=>$request,
                'trash_submission_count'=>$trash_submission_count
            ]);
        }
    }
}
