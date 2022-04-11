<?php


namespace Modules\priceVariation\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\categories\Models\Category;
use Modules\priceVariation\Models\PriceVariation;
use Modules\products\Models\Product;
use Modules\products\Repository\ProductRepositoryInterface;

class EloquentPriceVariationRepository extends EloquentBaseRepository implements PriceVariationRepositoryInterface
{
    protected $model="Modules\priceVariation\Models\PriceVariation";

    public function find($id)
    {
        if(is_array($id)){
            return PriceVariation::where($id)->firstOrFail();
        }
        else{
            return PriceVariation::findOrFail($id);
        }
    }

    public function create($request)
    {
        $params=$request->get('params',[]);
        $data=$request->all();
        if(array_key_exists('params',$data)){
            unset($data['params']);
        }

        $model=new PriceVariation($data);
        $model->product_id=$request->get('product_id');
        $i=1;
        foreach ($params as $key=>$value)
        {
            $key=str_replace('\\param'.$i,'',$key);
            $param_type='param'.$i.'_type';
            $param_id='param'.$i.'_id';
            $model->$param_type=str_replace("'",'',$key);
            $model->$param_id=$value;
            $i++;
        }

        $model->save();
    }

    public function trashCount()
    {
        $product_id=isset($_GET['product_id']) ? $_GET['product_id'] : 0;
        return PriceVariation::where('product_id',$product_id)->onlyTrashed()->count();
    }

    public function trashCountWithWhere($where)
    {
        return PriceVariation::where($where)->onlyTrashed()->count();
    }
    public function getList($request)
    {
        return PriceVariation::getData($request->all(),$request->get('product_id'));
    }

    public function update($id, $request)
    {
        $priceVariation=PriceVariation::findOrFail($id);
        $data=$request->all();
        if(array_key_exists('params',$data)){
            $params=$data['params'];
            unset($data['params']);
            $i=1;
            foreach ($params as $key=>$value)
            {
                $key=str_replace('\\param'.$i,'',$key);
                $param_type='param'.$i.'_type';
                $param_id='param'.$i.'_id';
                $priceVariation->$param_type=str_replace("'",'',$key);
                $priceVariation->$param_id=$value;
                $i++;
            }
        }

        $priceVariation->update($data);
    }

    public function VariationItem($cat_id)
    {
        $items=[];
        $cat=Category::where('id',$cat_id)->first();
        if($cat){
            if($cat->price_variation_item1!=null){
                $items['price_variation_item1']=$cat->price_variation_item1;
                $items['price_variation_item2']=$cat->price_variation_item2;
                $items['cat_id']=$cat->id;
            }
            else{
                $parent_cat=Category::where('id',$cat->parent_id)->first();
                if($parent_cat){
                    if($parent_cat->price_variation_item1!=null){
                        $items['price_variation_item1']=$parent_cat->price_variation_item1;
                        $items['price_variation_item2']=$parent_cat->price_variation_item2;
                        $items['cat_id']=$parent_cat->id;
                    }
                }
            }
        }
        return $items;
    }

    public function checkInsert($request,$id=0){
        $where=CompleteData('addPriceVariation',[
            'product_id'=>$request->get('product_id'),
        ]);
        if($id>0){
            $row=PriceVariation::where($where)
                ->where('id','!=',$id)->first();
        }
        else{
            $row=PriceVariation::where($where)->first();
        }
        return $row;
    }

    public function setProductMainPrice($price_variation){
        $lowestPrice=PriceVariation::where('product_id',$price_variation->product_id)
            ->where('product_number','>',0)->orderBy('price2','ASC')->first();

        $fastestSubmission=PriceVariation::where('product_id',$price_variation->product_id)
            ->orderBy('send_time','ASC')->first();

        $product=config()->get('app.product');

        if(!$product){
            $repository=app(ProductRepositoryInterface::class);
            $product=$repository->first([
                'id'=>$price_variation->product_id
            ]);
        }

        if($product){
            if($lowestPrice){

                $product->price=$lowestPrice->price2;

                if($lowestPrice->price1>$lowestPrice->price2){
                    $discount_price=$lowestPrice->price1-$lowestPrice->price2;
                    $product->discount_price=$discount_price;
                }
                else{
                    $product->discount_price=0;
                }

                if($product->status===-1 || $product->status===0){
                    $product->status=1;
                }
                $product->ready_to_shipment=$fastestSubmission->send_time;
                $product->update();
            }
            else{
                $product->discount_price=0;
                $product->status=0;
                $product->update();
            }
        }
    }

    public function setVariation($param1,$param2,$product_id){
        $where=['product_id'=>$product_id];
        if(is_array($param1)){
            $where=$where+['param1_type'=>$param1['type'],'param1_id'=>$param1['id']];
        }
        if(is_array($param2)){
            $where=$where+['param2_type'=>$param2['type'],'param2_id'=>$param2['id']];
        }
        $query=PriceVariation::where($where)->where('product_number','>',0);
        $query=CompleteData('product_page_variation_query',$query);
        return $query->orderBy('price2','ASC')
            ->first();
    }

    public function first($where,$relation=null)
    {
        $query=PriceVariation::where($where);
        if($relation){
            $query=$query->with($relation);
        }
        $query=$query->first();
        return $query;
    }

    public function all($whereIn, $relation)
    {
        $query=PriceVariation::whereIn('id',$whereIn);
        if($relation){
            $query=$query->with($relation);
        }
        $query=$query->get();
        return $query;
    }

    public function productVariations($where,$relation)
    {
        $query=PriceVariation::where($where)->where('product_number','>',0);
        if($relation){
            $query=$query->with($relation);
        }
        $query=CompleteData('get_product_variations',$query);
        return $query->orderBy('price2','ASC')->get();
    }
}
