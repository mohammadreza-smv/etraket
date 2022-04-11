<?php


namespace Modules\gallery\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\gallery\Repository\GalleryRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;

class GalleryController extends Controller
{
    protected $galleryRepository;

    public function __construct(GalleryRepositoryInterface $galleryRepository)
    {
        $this->galleryRepository=$galleryRepository;
    }

    public function gallery($id,ProductRepositoryInterface $productRepository)
    {
        $product=$productRepository->firstOrFail($id,['id','title']);
        $product_gallery= $this->galleryRepository->all($id);
        return CView('gallery::show',compact('product','product_gallery'));
    }

    public function gallery_upload($id,Request $request,ProductRepositoryInterface $productRepository)
    {
        $product=$productRepository->firstOrFail($id,['id']);
        return $this->galleryRepository->add($request,$id);
    }

    public function removeImageGallery($id,$product_id)
    {
        $image=$this->galleryRepository->find(['id'=>$id,'product_id'=>$product_id]);
        $this->galleryRepository->remove($image);
        return [
            'status'=>'ok',
        ];
    }

    public function change_images_status($id,$product_id,Request $request)
    {
        $this->galleryRepository->change_images_position($id,$request);
        return 'ok';
    }
}
