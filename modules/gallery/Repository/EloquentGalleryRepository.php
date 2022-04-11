<?php


namespace Modules\gallery\Repository;


use Modules\gallery\Models\ProductGallery;
use DB;

class EloquentGalleryRepository implements GalleryRepositoryInterface
{

    public function all($product_id)
    {
        return ProductGallery::where('product_id',$product_id)
            ->orderBy('position','ASC')->get();
    }

    public function add($request,$product_id)
    {
        $count=DB::table('product_gallery')->where('product_id',$product_id)->count();
        $image_url=upload_file($request,'file','gallery','image_'.$product_id.rand(1,100));
        if($image_url!=null){
            $count++;
            $id=DB::table('product_gallery')->insertGetId([
                'product_id'=>$product_id,
                'image_url'=>$image_url,
                'position'=>$count
            ]);
            return [
               'id'=>$id,
               'image_url'=>$image_url
            ];
        }
        else{
            return 0;
        }
    }

    public function remove($image)
    {
        $image_url=$image->image_url;
        $image->delete();

        if(file_exists('files/gallery/'.$image_url))
        {
            unlink('files/gallery/'.$image_url);
        }
    }

    public function find($id)
    {
        if(is_array($id)){
            return ProductGallery::where($id)->firstOrFail();
        }
        else{
            return ProductGallery::findOrFail($id);
        }
    }
    public function change_images_position($product_id,$request)
    {
        $position1=$request->get('position1');
        $position2=$request->get('position2');

        $id1=$request->get('id1');
        $id2=$request->get('id2');

        DB::table('product_gallery')->where([
            'product_id'=>$product_id,
            'id'=>$id2
        ])->update(['position'=>$position1]);

        DB::table('product_gallery')->where([
            'product_id'=>$product_id,
            'id'=>$id1
        ])->update(['position'=>$position2]);

    }
}
