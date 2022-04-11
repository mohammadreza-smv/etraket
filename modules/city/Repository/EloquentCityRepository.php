<?php


namespace Modules\city\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\city\Models\City;
use Modules\province\Models\Province;

class EloquentCityRepository extends EloquentBaseRepository implements CityRepositoryInterface
{
    protected $model="Modules\city\Models\City";

    public function find($id)
    {
        return City::findOrFail($id);
    }

    public function create($request)
    {
        $city=new City($request->all());
        $city->saveOrFail();
    }

    public function trashCount()
    {
        return City::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return City::getData($request->all());
    }

    public function update($id, $request)
    {
        $city=City::findOrFail($id);
        $city->update($request->all());
    }

    public function provinces(): array
    {
        if(class_exists('Modules\province\Models\Province')){
            return $province=Province::get()->pluck('name','id')->toArray();
        }
        else{
            [];
        }
    }

    public function first($id)
    {
        return City::find($id);
    }

    public function arrayList($where = [])
    {
        return City::where($where)->pluck('name', 'id')->toArray();
    }

    public function allCitiesForProvince($where=[]){
        return City::where($where)->get();
    }

    public function all($where = [],$select='*')
    {
        return City::where($where)->select($select)->get();
    }
}
