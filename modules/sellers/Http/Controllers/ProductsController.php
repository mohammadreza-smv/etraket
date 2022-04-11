<?php


namespace Modules\sellers\Http\Controllers;


use App\Http\Controllers\Admin\CustomController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Modules\gallery\Repository\GalleryRepositoryInterface;
use Modules\items\Repository\ItemRepositoryInterface;
use Modules\products\Repository\ProductRepositoryInterface;
use Modules\sellers\Repository\SellerRepositoryInterface;

class ProductsController extends Controller
{
    protected $productRepository=null;

    protected $sellerRepository;

    public function __construct(Request $request,SellerRepositoryInterface $sellerRepository)
    {
        if(file_exists(base_path('modules/products/Repository/ProductRepositoryInterface.php'))){
            $this->productRepository=app(ProductRepositoryInterface::class);
            config()->set('view.build_component','add');
            $this->sellerRepository=$sellerRepository;
        }
        else{
            $response=json_encode(['content'=>'<p>افزونه مورد نیاز غیر فعال می باشد</p>']);
            exit($response);
        }
    }

    public function index(Request $request){
        $products=$this->sellerRepository->panel_product_list($request);
        return CView('sellers::panel.products.index',[
            'product'=>$products,
            'req'=>$request
        ]);
    }

    public function create(){
        return CView('sellers::panel.products.create');
    }

    public function store(ProductRequest $request){

        $this->productRepository->create($request);
        return  [
            'redirect_url'=>url('sellers/panel/products'),
            'message'=>'ثبت محصول با موفقیت انجام شد'
        ];

    }

    public function gallery($product_id)
    {
        if(file_exists(base_path('modules/gallery/Repository/GalleryRepositoryInterface.php'))){

            $galleryRepository=app(GalleryRepositoryInterface::class);

            $seller_id=get_seller_id();

            $product=$this->productRepository->firstOrFail(
                ['id'=>$product_id, 'seller_id'=>$seller_id], ['id','title']);

            $product_gallery=$galleryRepository->all($product_id);

            config()->set('view.panel-gallery','add');

            return CView('sellers::panel.products.gallery',
                compact('product','product_gallery'));
        }

        return ['content'=>'<p>افزونه مورد نیاز غیر فعال می باشد</p>'];
    }

    public function gallery_upload($product_id,Request $request)
    {
        if(file_exists(base_path('modules/gallery/Repository/GalleryRepositoryInterface.php'))){

            $seller_id=get_seller_id();

            $product=$this->productRepository->firstOrFail(
                ['id'=>$product_id, 'seller_id'=>$seller_id], ['id']);

            $galleryRepository=app(GalleryRepositoryInterface::class);

            return $galleryRepository->add($request,$product_id);
        }
        else{
            return  0;
        }
    }

    public function change_images_status($id,Request $request)
    {
        if(file_exists(base_path('modules/gallery/Repository/GalleryRepositoryInterface.php'))){
            $galleryRepository=app(GalleryRepositoryInterface::class);
            $galleryRepository->change_images_position($id,$request);
            return 'ok';
        }
        else{
            return  'error';
        }
    }

    public function removeImageGallery($id,$product_id)
    {
        if(file_exists(base_path('modules/gallery/Repository/GalleryRepositoryInterface.php'))){

            $seller_id=get_seller_id();
            $galleryRepository=app(GalleryRepositoryInterface::class);

            $product=$this->productRepository->firstOrFail(
                ['id'=>$product_id, 'seller_id'=>$seller_id], ['id']);

            $image=$galleryRepository->find(['id'=>$id,'product_id'=>$product_id]);

            $galleryRepository->remove($image);

            return [
                'status'=>'ok',
            ];
        }
        return  'error';
    }

    public function product_items($product_id){

        if(file_exists(base_path('modules/items/Repository/ItemRepositoryInterface.php'))){

            $seller_id=get_seller_id();
            $repository=app(ItemRepositoryInterface::class);

            $product=$this->productRepository->firstOrFail(
                ['id'=>$product_id, 'seller_id'=>$seller_id], ['id','title','cat_id']);

            $product_items=$repository->product_items($product);

            return CView('sellers::panel.products.items',compact('product','product_items'));
        }

        return ['content'=>'<p>افزونه مورد نیاز غیر فعال می باشد</p>'];

    }

    public function add_product_items($id,Request $request){

        if(file_exists(base_path('modules/items/Repository/ItemRepositoryInterface.php'))){

            $seller_id=get_seller_id();
            $product=$this->productRepository->firstOrFail(
                ['id'=>$id, 'seller_id'=>$seller_id], ['id','title']);
            $repository=app(ItemRepositoryInterface::class);

            $repository->add_product_items($product,$request);

            return  [
                'redirect_url'=>url('sellers/panel/products/'.$product->id.'/items'),
                'message'=>'ثبت مشخصات فنی برای محصول انجام شد'
            ];
        }
        else{
            return  [
                'reload'=>url('sellers/panel'),
                'message'=>'افزونه مورد نیاز غیرر فعال می باشد ',
                'status'=>'error'
            ];
        }
    }

    public function total_product(Request $request){
         $products=$this->sellerRepository->total_product($request);
         return CView('sellers::panel.products.total',[
            'products'=>$products,
            'req'=>$request
         ]);
    }

    public function destroy($id)
    {
        $seller_id=get_seller_id();
        return $this->sellerRepository->remove_product();
    }

    public function edit($id){
        $product=$this->sellerRepository->findProductForEdit($id);
        if($product){
            return CView('sellers::panel.products.edit',compact('product'));
        }
        else{
            return [
                'redirect_url'=>url('sellers/panel/')
            ];
        }
    }

    public function update($id,Request $request){
        $product=$this->sellerRepository->findProductForEdit($id);
        if($product){

            $this->productRepository->update($id,$request,$product);
            return  [
                'redirect_url'=>url('sellers/panel/products'),
                'message'=>'ویرایش محصول با موفقیت انجام شد'
            ];
        }
    }
}
