<?php


namespace Modules\pages\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\pages\Repository\PageRepositoryInterface;

class ShopController extends Controller
{
    protected $repository=null;

    public function __construct(PageRepositoryInterface $repository)
    {
        parent::__construct(request());
        $this->repository=$repository;
    }

    public function page($url){
        $page=$this->repository->findPage(['url'=>$url]);
        return CView('pages::'.$this->view.'page',['page'=>$page]);
    }
}
