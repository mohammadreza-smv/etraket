<?php


namespace Modules\faq\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\faq\Models\CategoryCommonQuestion;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepositoryInterface
{
    protected $model='Modules\faq\Models\CategoryCommonQuestion';
    public function find($id)
    {
        return CategoryCommonQuestion::findOrFail($id);
    }

    public function create($request)
    {
        $CategoryCommonQuestion=new CategoryCommonQuestion($request->all());
        $img_url=upload_file($request,'pic','upload');
        $CategoryCommonQuestion->icon=$img_url;
        $CategoryCommonQuestion->saveOrFail();
    }

    public function trashCount()
    {
        return CategoryCommonQuestion::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return CategoryCommonQuestion::getData($request->all());
    }

    public function update($id, $request)
    {
        $data=$request->all();
        $category=CategoryCommonQuestion::findOrFail($id);
        $img_url=upload_file($request,'pic','upload');
        if($img_url!=null){
            $category->img=$img_url;
        }
        $category->update($data);
    }

    public function all()
    {
        return CategoryCommonQuestion::get();
    }
}
