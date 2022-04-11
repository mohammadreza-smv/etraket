<?php


namespace Modules\sendingType\Repository;


use App\Repositories\EloquentBaseRepository;
use Modules\sendingType\Models\SendingType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class EloquentSendingTypeRepository extends EloquentBaseRepository implements SendingTypeRepositoryInterface
{
    protected $model="Modules\sendingType\Models\SendingType";

    public function find($id)
    {
       return SendingType::findOrFail($id);
    }

    public function create($request)
    {
        try{
            $send_type=new SendingType($request->all());
            $img_url=upload_file($request,'pic','upload');
            $send_type->type_icon=$img_url;
            $send_type->save();
            $this->addColumnToCityTable($send_type);
            return true;
        }
        catch (\Exception $exception){
            return false;
        }
    }

    public function trashCount()
    {
        return SendingType::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return SendingType::getData($request->all());
    }

    public function update($id, $request)
    {
        try{
            $send_type=$this->find($id);
            $old=$send_type->type_key;
            $img_url=upload_file($request,'pic','upload');
            if($img_url){
                $send_type->type_icon=$img_url;
            }
            $send_type->update($request->all());
            $this->renameColumnInCityTable($old,$request->get('type_key'));
            return true;
        }
        catch (\Exception $exception){
            var_dump($exception->getMessage());
            return false;
        }

    }

    public function all()
    {
       return  SendingType::get();
    }

    protected function addColumnToCityTable($sending_type){
        if(Schema::hasTable('city')){
            $key=$sending_type->type_key;
            define('key',$key);
            Schema::table('city', function (Blueprint $table) {
                $table->string(key.'_send_time')->nullable();
                $table->string(key.'_send_price')->nullable();
                $table->string(key.'_min_order_price')->nullable();
            });
        }
    }

    protected function renameColumnInCityTable($old_key,$new_key){
        if(($old_key!=$new_key) && Schema::hasTable('city')){
            define('old_key',$old_key);
            define('new_key',$new_key);
            Schema::table('city', function (Blueprint $table) {
                $table->renameColumn(old_key.'_send_time',new_key.'_send_time');
                $table->renameColumn(old_key.'_send_price',new_key.'_send_price');
                $table->renameColumn(old_key.'_min_order_price',new_key.'_min_order_price');
            });
        }
    }
}
