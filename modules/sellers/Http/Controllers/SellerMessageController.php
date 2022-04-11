<?php


namespace Modules\sellers\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\messages\Http\Requests\MessageRequest;
use Modules\messages\Repository\MessageRepositoryInterface;
use Auth;
class SellerMessageController extends CustomController
{
    protected $repository=null;

    public function __construct(Request $request)
    {
        if(file_exists(base_path('modules/messages/Repository/MessageRepositoryInterface.php'))){
            $this->repository=app(MessageRepositoryInterface::class);
            config()->set('view.build_component','add');
        }
        else{
            $response=json_encode(['content'=>'<p>افزونه مورد نیاز غیر فعال می باشد</p>']);
            exit($response);
        }
    }

    public function index(Request $request){
        $user_id=Auth::guard('seller')->user()->id;
        $messages=$this->repository->getList($request,$user_id,'Modules\sellers\Models\Seller');

        return CView('sellers::panel.messages.index',
            ['messages'=>$messages, 'req'=>$request]);
    }

    public function showMessageContent($id){
        $user_id=Auth::guard('seller')->user()->id;
        $user=Auth::guard('seller')->user();
        $user_type='Modules\sellers\Models\Seller';
        $message=$this->repository->getUserMessageContent($id,$user_id,$user_type);
        return CView('sellers::panel.messages.content',
            ['message'=>$message,'user_type'=>$user_type,'user'=>$user]);
    }

    public function addAnswer($id,MessageRequest $request)
    {
        $user_id=Auth::guard('seller')->user()->id;
        $user_type='Modules\users\Models\User';
        $this->repository->addAnswer($id,$user_id,$request,$user_type,'1','Modules\sellers\Models\Seller');
        return [
            'redirect_url'=>url('sellers/panel/messages/'.$id),
            'message'=>'ثبت  با موفقیت انجام شد'
        ];
    }

    public function addMessageForm(){
        return CView('sellers::panel.messages.create',[]);
    }

    public function store(MessageRequest $request)
    {
        $user=Auth::guard('seller')->user();
        $user_type='Modules\sellers\Models\Seller';
        $this->repository->addMessage($request,$user,$user->id,$user_type);
        return  [
            'redirect_url'=>url('sellers/panel/messages'),
            'message'=>'ثبت با موفقیت انجام شد'
        ];
    }
}
