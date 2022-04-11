<?php


namespace App;
use App\Observers\ModuleObserver;
use Illuminate\Database\Eloquent\Model;
use Modules\priceVariation\Models\PriceVariation;

class CustomModel extends  Model
{
    protected static $modelTable;
    protected static function boot()
    {
        parent::boot();
        $class=get_called_class();
        if($class){
            $class::observe(ModuleObserver::class);
        }
    }

    public function __call($method, $parameters)
    {
        self::$modelTable=$this->table;
        $action=$this->table.'_'.$method.'_relation';
        $result=run_action($action,[],true);
        if(is_array($result) && sizeof($result)==1){
            $function=$result[0];
            return  $function($this);
        }
        return parent::__call($method, $parameters);
    }

    public  static  function CPaginate($request,$filters=[],$relations=[]){

        $string='?';
        $query=self::orderBy('id','DESC')->with($relations);
        if(inTrashed($request))
        {
            $query=$query->onlyTrashed();
            $string=create_paginate_url($string,'trashed=true');
        }
        if(sizeof($filters)>0){
            foreach ($filters as $key=>$array){
                if(sizeof($array)===3){
                    if(!empty($array[2])){
                        if($array[1]==='like'){
                            $query=$query->where($array[0],'like','%'.$array[2].'%');
                            $string=create_paginate_url($string,$array[0].'='.$array[2]);
                        }
                    }
                }
                else if(sizeof($array)===2){
                    if(!empty($array[1])){
                        if(is_array($array[1])){
                            $query=$query->whereIn($array[0],$array[1]);
                        }
                        else{
                            $query=$query->where($array[0],$array[1]);
                        }
                        $string=create_paginate_url($string,$array[0].'='.$request[$array[0]]);
                    }
                }
            }
        }
        $completeQuery=CompleteData(self::$modelTable.'_cpaginate',['query'=>$query,'string'=>$string]);
        if(array_key_exists('query',$completeQuery)){
            $query=$completeQuery['query'];
        }
        if(array_key_exists('string',$completeQuery)){
            $string=$completeQuery['string'];
        }
        $query=$query->paginate(10);
        $query->withPath($string);

        return $query;
    }
}
