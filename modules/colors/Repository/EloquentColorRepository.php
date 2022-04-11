<?php


namespace Modules\colors\Repository;


use App\Product;
use App\Repositories\EloquentBaseRepository;
use Modules\colors\Models\Color;
use Modules\colors\Models\ProductColor;

class EloquentColorRepository extends EloquentBaseRepository implements ColorRepositoryInterface
{
    protected $model='Modules\colors\Models\Color';

    public function find($id)
    {
        return Color::findOrFail($id);
    }

    public function create($request)
    {
        $color=new Color($request->all());
        $color->saveOrFail();
    }

    public function trashCount()
    {
        return Color::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Color::getData($request->all());
    }

    public function update($id, $request)
    {
        $color=Color::findOrFail($id);
        $color->update($request->all());
    }

    public function selectList()
    {
        return Color::get();
    }

    public function setProductColor($price_variation){
        $product=config()->get('app.product');
        if($product){
            $color_id=0;
            if($price_variation->param1_type=='Modules\colors\Models\Color'){
                $color_id=$price_variation->param1_id;
            }
            else if($price_variation->param2_type=='Modules\colors\Models\Color'){
                $color_id=$price_variation->param2_id;
            }
            if($color_id){
                $data=[
                    'product_id'=>$product->id,
                    'color_id'=>$color_id,
                    'cat_id'=>$product->cat_id
                ];
                ProductColor::firstOrCreate($data);
            }
        }
    }

    public function getColorCategory($catId)
    {
        return ProductColor::where('cat_id',$catId)->first();
    }

    public function all()
    {
        return Color::get();
    }
}
