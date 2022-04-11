<?php


namespace Modules\pages\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\pages\Models\Page;

class EloquentPageRepository extends EloquentBaseRepository implements  PageRepositoryInterface
{
    protected $model='Modules\pages\Models\Page';
    public function find($id)
    {
        return Page::findOrFail($id);
    }

    public function create($request)
    {
        $page=new Page($request->all());
        $page_url=get_url($request->get('title'));
        $page->url=$page_url;
        $page->saveOrFail();
    }

    public function trashCount()
    {
        return Page::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Page::getData($request->all());
    }

    public function update($id, $request)
    {
        $page=$this->find($id);
        $page_url=get_url($request->get('title'));
        $page->url=$page_url;
        $page->update($request->all());
    }

    public function findPage($where)
    {
        return Page::where($where)->firstOrFail();
    }
}
