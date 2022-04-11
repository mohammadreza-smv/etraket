<?php


namespace Modules\incredibleOffers\Repository;


use App\Repositories\EloquentBaseRepository;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Modules\categories\Models\Category;
use Modules\incredibleOffers\jobs\IncredibleOffers;
use Modules\priceVariation\Models\PriceVariation;

class EloquentIncredibleOffersRepository extends EloquentBaseRepository implements IncredibleOffersRepositoryInterface
{

    public function update($price_variation, $request)
    {
        $date1=$request->get('date1');
        $date2=$request->get('date2');
        $offers_first_time=getTimestamp($date1,'first');
        $offers_last_time=getTimestamp($date2,'last');

        $price_variation->offers_first_date=$date1;
        $price_variation->offers_last_date=$date2;
        $price_variation->offers_first_time=$offers_first_time;
        $price_variation->offers_last_time=$offers_last_time;
        $price_variation->offers=1;

        DB::beginTransaction();
        try{

            $row=DB::table('old_price')->where('price_variation_id',$price_variation->id)->first();
            if(!$row)
            {
                $this->addNewPriceRow($price_variation,$request);
            }
            else
            {
                $this->updatePriceRow($row,$price_variation,$request);
            }

            $all=$request->all();
            unset($all['date1']);
            unset($all['date2']);

            $price_variation->update($all);

            $second=$offers_last_time-time()+1;
            IncredibleOffers::dispatch($price_variation->id)->delay(now()->addSecond($second));

            DB::commit();

            return [
                'status'=>'ok',
            ];
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return [
                'status'=>'error',
            ];
        }
    }

    protected function addNewPriceRow($variation,$request){

        $n=$variation->product_number-$request->get('product_number');
        if($n<0){
            $n=0;
        }
        $insert_id=DB::table('old_price')
            ->insertGetId([
                'price_variation_id'=>$variation->id,
                'price1'=>$variation->price1,
                'price2'=>$variation->price2,
                'product_number'=>$n,
                'product_number_cart'=>$variation->product_number_cart,
                'number_product_sales'=>$request->get('product_number'),
            ]);
    }

    protected function updatePriceRow($row,$variation,$request){
        $n=$row->product_number;
        if($row->number_product_sales>$request->get('product_number'))
        {
            $n1=$row->number_product_sales-$request->get('product_number');
            $n=$n+$n1;
        }
        else
        {
            $n1=$request->get('product_number')-$row->number_product_sales;
            $n=$n-$n1;
        }
        DB::table('old_price')
            ->where(['price_variation_id'=>$variation->id])
            ->update([
                'number_product_sales'=>$request->get('product_number'),
                'product_number'=>$n
            ]);
    }

    public function remove($priceVariation)
    {
        $old_price=DB::table('old_price')->where('price_variation_id',$priceVariation->id)->first();
        if($old_price)
        {
            $priceVariation->price1=$old_price->price1;
            $priceVariation->price2=$old_price->price2;
            if($old_price->product_number>0)
            {
                $priceVariation->product_number=$priceVariation->product_number+$old_price->product_number;
            }

            DB::table('old_price')
                ->where('price_variation_id',$priceVariation->id)->delete();
        }
        $priceVariation->offers=0;
        $priceVariation->update();
    }

    public function productList($request)
    {
        $string='?';
        $search_text=$request->get('search_text');

        $variation=PriceVariation::with(['param1','param2'])
            ->where('offers',1)->orderBy('id','DESC');

        if(empty($search_text)){
            $variation=$variation->with('product')->whereHas('product');
        }
        else{
            $string=create_paginate_url($string,'search_text='.$request['search_text']);
            define('search_text',$search_text);
            $variation=$variation->with('product')->whereHas('product',function (Builder $query){
                $query->where('title','like','%'.search_text.'%');
            });
        }

        $variation=$variation->paginate(10);
        $variation->withPath($string);
        return $variation;
    }

    public function lastOffers($cat1,$cat2){
        $priceVariation=PriceVariation::where('offers',1)->with('product');

        if($cat1>0){
            $catList1=$this->getOffersProductCatList($cat1);
            define('catList1',$catList1);
        }
        if($cat2>0){
            $catList2=$this->getOffersProductCatList($cat2);
            define('catList2',$catList2);

        }

        if($cat1>0 || $cat2>0){
            $priceVariation=$priceVariation->whereHas('product',function (Builder $query){
                 if(defined('catList1')){
                     $query->whereIn('cat_id',catList1);
                 }
                if(defined('catList2')){
                    $query->whereNotIn('cat_id',catList2);
                }
            });
        }
        else{
            $priceVariation=$priceVariation->whereHas('product');
        }

        $priceVariation=$priceVariation->limit(15)->inRandomOrder()->get();
        return $priceVariation;
    }

    protected function getOffersProductCatList($catId){
        $array=[];
        $category=Category::where('id',$catId)->with('getChild.getChild.getChild')->first();
        if($category){
            $array[]=$catId;

            foreach ($category->getChild as $key1=>$child1){
                $array[]=$child1->id;

                foreach ($child1->getChild as $key2=>$child2){
                    $array[]=$child2->id;

                    foreach ($child2->getChild as $key3=>$child3){
                        $array[]=$child3->id;
                    }
                }
            }
        }
        return $array;
    }
}
