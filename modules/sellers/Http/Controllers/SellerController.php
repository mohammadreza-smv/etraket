<?php


namespace Modules\sellers\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use App\Lib\Jdf;
use Illuminate\Http\Request;
use Modules\sellers\Exports\Pay;
use Modules\sellers\Http\Requests\SellerRequest;
use Modules\sellers\Imports\PaymentImport;
use Modules\sellers\Repository\SellerRepositoryInterface;
use Excel;
use DB;
use Modules\setting\Repository\SettingRepositoryInterface;

class SellerController extends CustomController
{
    protected $title = 'فروشنده';

    protected $route_params = 'sellers';

    protected $repository;

    public function __construct(SellerRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request){

        $sellers =$this->repository->getList($request);
        $trash_seller_count =$this->repository->trashCount();

        return CView('sellers::index', [
            'sellers' => $sellers,
            'trash_seller_count' => $trash_seller_count,
            'req' => $request
        ]);
    }

    public function edit($id){

        $seller=$this->repository->find($id);
        return CView('sellers::edit',[
            'seller'=> $seller,
        ]);
    }

    public function update($id,SellerRequest $request)
    {
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/sellers/list'),
            'message'=>'ویرایش اطلاعات فروشنده با موفقیت انجام شد'
        ];
    }

    public function show($id, Request $request){
         $seller=$this->repository->firstOrFail($id);
         $products=$this->repository->products($id);
         $document=$this->repository->documents($id);
         return CView('sellers::show',compact('seller','products','document'));
    }

    public function export()
    {
        $payment_data=$this->repository->export();
        if($payment_data['count']>0){
            return Excel::download(new Pay($payment_data['count'],$payment_data['sum']), 'pay.xlsx');
        }
        else{
            return CView('sellers::payment.excel_export');
        }
    }

    public function import()
    {
        return CView('sellers::payment.import');
    }

    public function add_payment(Request $request)
    {
        $this->validate($request,['payment_file'=>'required|file|mimes:xlsx'],[],['payment_file'=>'فایل اکسل']);

        $file_name=upload_file($request, 'payment_file', 'import');
        if($file_name){
            $file= 'files/import/'.$file_name;
            DB::beginTransaction();
            try {
                Excel::import(new PaymentImport(), $file);
                DB::commit();
                return redirect()->back()->with('message', 'ثبت اطلاعات با موفقیت انجام شد');
            }
            catch (\Exception $exception) {
                DB::rollBack();
                return redirect()->back()->with('warring', 'خطا در ثبت اطلاعات مجددا تلاش نمایید');
            }
        }
        else{
            return redirect()->back()->with('warring','خطا در ثبت اطلاعات مجددا تلاش نمایید');
        }
    }

    public function payments(Request $request){
        $payments=$this->repository->payments($request);
        $sellers=$this->repository->sellers();
        return CView('sellers::payment.list',['payments'=> $payments, 'sellers'=> $sellers,'req'=> $request]);
    }

    public function sms_setting(Request $request,SettingRepositoryInterface $settingRepository){
        if($request->isMethod('post')){
            $settingRepository->set_data($request->all());
            return  [
                'redirect_url'=>url('admin/sellers/sms/channel'),
                'message'=>'ثبت تنظیمات با موفقیت انجام شد'
            ];
        }
        else{
            $data=$settingRepository->get_data([
                'sellers-channel',
                'sellers-line_number',
                'sellers-api-key',
                'sellers-active_template'
            ]);
        }
        $channels=run_action('sms_channel_info',[],true);

        $channelList=array();
        foreach ($channels as $channel){
            $channelList[$channel['name']]=$channel['title'];
        }
        return CView('sellers::sms_setting',compact('channelList','data'));
    }

    public function statistics($seller_id,Request $request){
        $seller=$this->repository->find($seller_id);
        config()->set('seller_component','add');
        return CView('sellers::statistics',compact('seller'));
    }

    public function get_statistics($seller_id,Request $request){
        $jdf=new Jdf();
        $now=$jdf->tr_num($jdf->jdate('Y'));
        $year=$request->has('year') ? $request->get('year') : $now;
        return $this->repository->get_seller_sale_statistics($seller_id,$year,$now);
    }
}
