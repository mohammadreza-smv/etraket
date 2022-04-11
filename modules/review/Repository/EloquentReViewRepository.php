<?php


namespace Modules\review\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\review\Models\ReView;
use DB;
class EloquentReViewRepository extends EloquentBaseRepository implements ReViewRepositoryInterface
{
    protected $model="Modules\\review\Models\ReView";

    protected $product_id=0;

    public function find($id)
    {
       return ReView::findOrFail($id);
    }

    public function create($request)
    {
        $review=new ReView($request->all());
        $review->product_id=$this->product_id;
        $review->saveOrFail();
    }

    public function trashCount()
    {
        return ReView::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return ReView::getData($request->all());
    }

    public function update($id, $request)
    {
        $review=ReView::findOrFail($id);
        $review->update($request->all());
    }

    public function setProductId($id)
    {
        $this->product_id=$id;
    }

    public function getPrimary($product_id){
        return ReView::whereNull('title')
            ->where('product_id',$product_id)->first();
    }

    public function addPrimary($product_id,$request)
    {
        DB::table('review_product')
            ->whereNull('title')->where('product_id',$product_id)->delete();
        if(!empty($request->get('tozihat')))
        {
            $review=new ReView($request->all());
            $review->product_id=$product_id;
            $review->saveOrFail();
        }
    }

    public function getProductReview($product_id){
        return ReView::where('product_id',$product_id)->get();
    }
}
