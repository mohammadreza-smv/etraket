<?php


namespace Modules\warranty\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\warranty\Models\Warranty;

class EloquentWarrantyRepository extends EloquentBaseRepository implements WarrantyRepositoryInterface
{
    protected $model="Modules\warranty\Models\Warranty";

    public function find($id)
    {
        return Warranty::findOrFail($id);
    }

    public function create($request)
    {
        $warranty=new Warranty($request->all());
        $warranty->saveOrFail();
    }

    public function trashCount()
    {
        return Warranty::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Warranty::getData($request->all());
    }

    public function update($id, $request)
    {
        $warranty=Warranty::findOrFail($id);
        $warranty->update($request->all());
    }

    public function selectList():array {
        return Warranty::pluck('name','id')->toArray();
    }
}
