<?php


namespace Modules\blog\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\blog\Models\BlogCategory;

class EloquentBlogCategoryRepository extends EloquentBaseRepository implements BlogCategoryRepositoryInterface
{

    protected  $model='Modules\blog\Models\BlogCategory';

    public function find($id)
    {
        return BlogCategory::findOrFail($id);
    }

    public function create($request)
    {
        $category=new BlogCategory($request->all());
        $category->url=get_url($request->get('name'));
        $category->save();
    }

    public function trashCount()
    {
        return BlogCategory::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return BlogCategory::getData($request->all());
    }

    public function update($id, $request)
    {
        $category=BlogCategory::findOrFail($id);
        $category->url=get_url($request->get('name'));
        $category->update($request->all());
    }

    public function parentCategories()
    {
          return [0=>'دسته اصلی']+BlogCategory::where('parent_id',0)->pluck('name','id')->toArray();
    }

    public function getCategories(): array
    {
        $array=[];
        $list=BlogCategory::with('child')->where('parent_id',0)->get();
        foreach ($list as $key=>$value)
        {
            $array[$value->id]=$value->name;
            foreach ($value->child as $key2=>$value2)
            {
                $array[$value2->id]=' - '.$value2->name;
            }
        }
        return $array;
    }

    public function all(){
        return BlogCategory::with('child')->where('parent_id',0)->get();
    }
}
