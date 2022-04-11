<?php


namespace Modules\shop\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\catBrands\Repository\CatBrandRepositoryInterface;
use Modules\categories\Repository\CategoryRepositoryInterface;
use Modules\city\Models\City;
use Modules\colors\Repository\ColorRepositoryInterface;
use Modules\filters\Repository\FilterRepositoryInterface;

class ApiController extends Controller
{
    public function filters(CategoryRepositoryInterface $repository,$cat_id)
    {
        $args=[];
        $category=$repository->first(['id'=>$cat_id]);

        if($category){

            $args['category']=$category;
            $args['child_category']=$repository->getChildNullUrlCat($cat_id);

            if(file_exists(base_path('modules/catBrands/Repository/CatBrandRepositoryInterface.php'))){
                $brandRepository=app(CatBrandRepositoryInterface::class);
                $brands=$brandRepository->getWithRelation('getBrand',['cat_id'=>$category->id]);
                $args['brands']=$brands;
            }

            if(file_exists(base_path('modules/colors/Repository/ColorRepositoryInterface.php'))){
                $colorRepository=app(ColorRepositoryInterface::class);
                $checkHasColor=$colorRepository->getColorCategory($category->id);
                if($checkHasColor){
                    $args['colors']=$colorRepository->all();
                }
            }

        }

        return CompleteData('search_filters',$args);
    }

    public function seller_cities(){
        return  City::select(['id','name'])->whereHas('citySellers')->get();
    }
}
