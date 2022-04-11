<?php


namespace Modules\faq\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\faq\Models\CategoryCommonQuestion;
use Modules\faq\Models\CommonQuestion;

class EloquentQuestionRepository extends EloquentBaseRepository implements QuestionRepositoryInterface
{
    protected  $model='Modules\faq\Models\CommonQuestion';
    public function find($id)
    {
        return CommonQuestion::findOrFail($id);
    }

    public function create($request)
    {
        $pin=$request->has('pin') ? 1 : 0;
        $CommonQuestion=new CommonQuestion($request->all());
        $CommonQuestion->pin=$pin;
        $CommonQuestion->save();
    }

    public function trashCount()
    {
       return CommonQuestion::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return CommonQuestion::getData($request->all());
    }

    public function update($id, $request)
    {
        $data=$request->all();
        $CommonQuestion=CommonQuestion::findOrFail($id);
        $pin=$request->has('pin') ? 1 : 0;
        $data['pin']=$pin;
        $CommonQuestion->update($data);
    }

    public function getCat(): array
    {
        return  CategoryCommonQuestion::pluck('title','id')->toArray();
    }

    public function get($where=[])
    {
        return CommonQuestion::where($where)->get();
    }

    public function search($key, $value)
    {
        return CommonQuestion::where($key,'like','%'.$value.'%')->get();
    }
}
