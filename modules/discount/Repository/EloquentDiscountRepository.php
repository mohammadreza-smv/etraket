<?php


namespace Modules\discount\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\pages\Models\Page;
use Modules\discount\Models\Discount;
class EloquentDiscountRepository extends EloquentBaseRepository implements  DiscountRepositoryInterface
{
    protected $model='Modules\discount\Models\Discount';

    public function find($id)
    {
        return Discount::findOrFail($id);
    }

    public function create($request)
    {
        $date=getTimestamp($request->get('expiry_time'),'last');
        $discount=new Discount($request->all());
        $discount->number_usable=( $request->get('number_usable')==null) ? 1 : $request->get('number_usable');
        $discount->expiry_time=$date;
        $discount->saveOrFail();
    }

    public function trashCount()
    {
        return Discount::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Discount::getData($request->all());
    }

    public function update($id, $request)
    {
        $discount=$this->find($id);
        $date=getTimestamp($request->get('expiry_time'),'last');
        $formData=$request->all();
        $formData['expiry_time']=$date;
        $discount->update($formData);
    }
}
