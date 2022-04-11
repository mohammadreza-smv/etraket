<?php


namespace Modules\sellers\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\sellers\Repository\ApiRepositoryInterface;

class ApiController extends Controller
{
    protected $repository;

    public function __construct(ApiRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function first_step_register(Request $request)
    {
        return  $this->repository->first_step_register($request);
    }

    public function second_step_register(Request $request){
        return  $this->repository->second_step_register($request);
    }

    public function resend_active_code(Request $request){
        return $this->repository->resend_active_code($request);
    }

    public function check_active_code(Request $request){
        return $this->repository->check_active_code($request);
    }

    public function upload_document(Request $request){
        return $this->repository->upload_document($request);
    }

    public function get_month_sales_statistics(){
        return $this->repository->monthSalesStatistics();
    }
}
