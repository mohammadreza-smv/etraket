<?php


namespace Modules\province\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\province\Models\Province;

class EloquentProvinceRepository extends EloquentBaseRepository implements ProvinceRepositoryInterface
{
    protected $model="Modules\province\Models\Province";

    public function find($id)
    {
        return Province::findOrFail($id);
    }

    public function create($request)
    {
        $Province=new Province($request->all());
        $Province->saveOrFail();
    }

    public function trashCount()
    {
        return Province::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return Province::getData($request->all());
    }

    public function update($id, $request)
    {
        $province=Province::findOrFail($id);
        $province->update($request->all());
    }

    public function arrayList()
    {
       return Province::pluck('name','id')->toArray();
    }

    public function all()
    {
        return Province::get();
    }
}
