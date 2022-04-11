<?php


namespace Modules\categories\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\categories\Models\Category;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepositoryInterface
{
    protected  $model='Modules\categories\Models\Category';

    public function find($id)
    {
       return Category::findOrFail($id);
    }

    public function create($request)
    {
        $Category=new Category($request->all());
        $Category->url=get_url($request->get('ename'));
        $img_url=upload_file($request,'pic','upload');
        $Category->img=$img_url;
        $Category->save();
    }

    public function trashCount()
    {
        return Category::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Category::getData($request->all());
    }

    public function update($id, $request)
    {
        $data=$request->all();
        $category=Category::findOrFail($id);
        $category->url=get_url($request->get('ename'));
        $img_url=upload_file($request,'pic','upload');
        if($img_url!=null){
            $category->img=$img_url;
        }
        $category->update($data);
    }

    public function catList(): array
    {
        return  Category::catList();
    }

    public function all()
    {
        return Category::with('getChild.getChild.getChild')
            ->where('parent_id',0)->get();
    }

    public function onlyFind($id)
    {
        return Category::find($id);
    }

    public function catList2(): array
    {
        return  Category::catList2();
    }

    public function firstWithRelation($relation, $where)
    {
        return Category::with($relation)
            ->where($where)->first();
    }

    public function getWithIds($ids,$key)
    {
        return Category::whereIn($key,$ids)->get();
    }

    public function getWithRelation($relation,$where){
        $categories=Category::with($relation);
        if(sizeof($where)>0){
            $categories=$categories->where($where);
        }
        return $categories->get();
    }

    public function getChildNullUrlCat($id){
        return Category::where('parent_id',$id)
            ->whereNull('search_url')->get();
    }

    public function first($where)
    {
        return Category::where($where)->first();
    }
}
