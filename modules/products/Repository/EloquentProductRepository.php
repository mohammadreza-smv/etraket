<?php


namespace Modules\products\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\products\Models\Product;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepositoryInterface
{

    protected $model='Modules\products\Models\Product';

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function create($request)
    {
        //$use_for_gift_cart=$request->has('use_for_gift_cart') ? 'yes' : 'no';
        $fake=$request->has('fake') ? 1 : 0;
        $product=new Product($request->all());
        if(empty($request->get('product_url',''))){
            $product_url=get_url($request->get('title'));
            $product->product_url=$product_url;
        }
        $image_url=upload_file($request,'pic','products');
        $product->image_url=$image_url;
       // $product->use_for_gift_cart=$use_for_gift_cart;
        $product->fake=$fake;
        $product->view=0;
        $product->product_count=0;
        create_fit_pic('files/products/'.$image_url,$image_url);
        $product->saveOrFail();
    }

    public function trashCount()
    {
        return Product::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return  Product::getData($request->all());
    }

    public function update($id, $request,$product=null)
    {
        $data=$request->all();
        //$use_for_gift_cart=$request->has('use_for_gift_cart') ? 'yes' : 'no';
        $fake=$request->has('fake') ? 1 : 0;
        $product=$product==null ? Product::findOrFail($id) : $product;

        if(empty($request->get('product_url'))){
            $product_url=get_url($request->get('title'));
            $product->product_url=$product_url;
            unset($data['product_url']);
        }

       // $data['use_for_gift_cart']=$use_for_gift_cart;
        $data['fake']=$fake;
        $image_url=upload_file($request,'pic','products');
        if (!empty($image_url))
        {
            remove_file($product->image_url,'products');
            remove_file($product->image_url,'thumbnails');
            create_fit_pic('files/products/'.$image_url,$image_url);
            $product->image_url=$image_url;
        }
        $product->update($data);
    }
    public function firstOrFail($id,$select,$relation=[])
    {
        $product=Product::select($select);
        if(is_array($id)){
            $product=$product->where($id);
        }
        else{
            $product=$product->where('id',$id);
        }
        if(sizeof($relation)>0){
            $product=$product->with($relation);
        }

        $product=$product->firstorFail();

        return $product;
    }

    public function findForPage($product_id, $product_url)
    {
        $id=str_replace('dkp-','',$product_id);
        $where=['id'=>$id];
        if($product_url!=null)
        {
            $where['product_url']=$product_url;
        }

        $product_relation=CompleteData('show_product_relation',[]);

        return Product::with($product_relation)->where($where)->firstOrFail();

    }

    public function findWithWhere($where,$relation=[]){
        $product=Product::where($where);
        if(is_array($relation) && sizeof($relation)>0){
            $product=$product->with($relation);
        }
        return $product->first();
    }

   public function get($where=[],$whereIn=[],$whereKey=null,$select=[]){
       $query=Product::where($where);
       if(sizeof($whereIn)>0 && $whereKey!=null){
           $query=$query->whereIn($whereKey,$whereIn);
       }
       if(sizeof($select)>0){
           $query=$query->select($select);
       }
       return $query=$query->get();
   }

    public function first($where = [], $relation = [],$select=['*'])
    {
        return Product::where($where)->select($select)->with($relation)->first();
    }
}
