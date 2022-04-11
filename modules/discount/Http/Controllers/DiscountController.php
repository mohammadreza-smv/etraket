<?php


namespace Modules\discount\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\discount\Http\Requests\DiscountRequest;
use Modules\discount\Repository\DiscountRepositoryInterface;
use Session;
class DiscountController extends CustomController
{
    protected $title='تخفیف';

    protected $route_params='discount';

    protected $repository;

    public function __construct(DiscountRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request){

        $discount=$this->repository->getList($request);

        $trash_discount_count=$this->repository->trashCount();

        return CView('discount::index',[
            'discount'=>$discount,
            'trash_discount_count'=>$trash_discount_count,
            'req'=>$request
        ]);
    }

    public function create(){
        return CView('discount::create');
    }

    public function store(DiscountRequest $request){
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/discount'),
            'message'=>'ثبت کد تخفیف با موفقیت انجام شد'
        ];
    }

    public function edit($id)
    {
        $discount=$this->repository->find($id);
        return CView('discount::edit',['discount'=>$discount]);
    }
    public function update($id,DiscountRequest $request)
    {
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/discount'),
            'message'=>'ویرایش کد تخفیف با موفقیت انجام شد'
        ];
    }

    public function check_discount_code(Request $request){
        $code=$request->get('code');
        $discountCode=new \Modules\discount\Models\DiscountCode($code);
        $result=$discountCode->check();
        if(is_array($result) && $result['status']=='ok' && $result['discount_value']>0){
            Session::put('discount_code',$code);
            Session::put('discount_value',$result['discount_value']);
        }
        return $result;
    }
}
