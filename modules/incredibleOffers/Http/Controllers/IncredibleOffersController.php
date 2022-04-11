<?php


namespace Modules\incredibleOffers\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\incredibleOffers\Http\Requests\OffersRequest;
use Modules\incredibleOffers\Repository\IncredibleOffersRepositoryInterface;
use Modules\priceVariation\Repository\PriceVariationRepositoryInterface;

class IncredibleOffersController extends CustomController
{
    protected $repository;

    public function __construct(PriceVariationRepositoryInterface $variationRepository)
    {
        $this->repository=$variationRepository;
    }

    public function create($id){
        $price_variation= $this->repository->find($id);
        return CView('incredibleOffers::form',compact('price_variation'));
    }

    public function update($id,OffersRequest $request, IncredibleOffersRepositoryInterface $incredibleOffersRepository)
    {
        $price_variation= $this->repository->find($id);
        $result=$incredibleOffersRepository->update($price_variation,$request);

        if(is_array($result) && $result['status']=='ok'){
            return [
               'message'=>'ثبت با موفقیت انجام شد',
               'redirect_url'=>url('admin/product/price_variation?product_id='.$price_variation->product_id)
            ];
        }
        else{
            return [
                'message'=>'خطا در ثبت اطلاعات ، مجددا تلاش نمایید',
                'redirect_url'=>url('admin/product/incredible-offers/'.$id.'/add'),
                'status'=>'error'
            ];
        }
    }

    public function offers_list(Request $request,IncredibleOffersRepositoryInterface $incredibleOffersRepository)
    {
        $list=$incredibleOffersRepository->productList($request);
        return CView('incredibleOffers::list',['list'=>$list,'req'=>$request]);
    }

    public function remove($id, IncredibleOffersRepositoryInterface $incredibleOffersRepository){

        $price_variation=$this->repository->find($id);
        $incredibleOffersRepository->remove($price_variation);
        return [
            'message'=>'حذف با موفقیت انجام شد',
            'redirect_url'=>url('admin/incredible-offers'),
        ];
    }
}
