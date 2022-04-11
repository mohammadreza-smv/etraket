<?php


namespace Modules\sendingType\Models;


use Modules\city\Repository\CityRepositoryInterface;
use Modules\setting\Repository\SettingRepositoryInterface;

class SendingInfo
{

    protected $city;

    protected $sending_options;

    public function __construct()
    {
        $city_repository=app(CityRepositoryInterface::class);

        $this->city=$city_repository->first($this->city_id);

        $types=$this->set_sending_method();

        $option_keys=$this->getAllOption($types);

        $setting_repository=app(SettingRepositoryInterface::class);

        $this->sending_options=$setting_repository->getValues($option_keys);
    }

    protected function getAllOption($types){
        $array=array();
        $i=0;
        foreach ($types as $type){
            $array[$i]=$type.'_send_time';
            $i++;
            $array[$i]=$type.'_send_price';
            $i++;
            $array[$i]=$type.'_min_order_price';
            $i++;
        }
        return $array;
    }

    public function set_sending_method(){
        $array=array();
        foreach ($this->send_methods as $method){
            $array[]=$method->type_key;
        }
        return $array;
    }

    public function get_sending_info($sending_method,$total_price){
        $array=[
            'sending_price'=>0,
        ];
        $city=$this->city;
        $property=$sending_method.'_send_price';
        if($city && !empty($city->$property)){

            $property2=$sending_method.'_min_order_price';
            $property3=$sending_method.'_send_time';

            $sending_price=$city->$property;
            $min_order_price=intval($city->$property2);
            $sending_time=$city->$property3;


            if($min_order_price){
                if($total_price<$min_order_price){
                    $array['sending_price']=intval($sending_price);
                }
            }
            else{
                $array['sending_price']=intval($sending_price);
            }
            $array['sending_time']=intval($sending_time);

        }
        else if(array_key_exists($property,$this->sending_options) && !empty($this->sending_options[$property])){

            $min_order_price=array_key_exists($sending_method.'_min_order_price',$this->sending_options) ? $this->sending_options[$sending_method.'_min_order_price'] : null;
            $sending_price=array_key_exists($sending_method.'_send_price',$this->sending_options) ? $this->sending_options[$sending_method.'_send_price'] : 0;
            $sending_time=array_key_exists($sending_method.'_send_time',$this->sending_options) ? $this->sending_options[$sending_method.'_send_time'] : 0;
            if($min_order_price){
                if($total_price<$min_order_price){
                    $array['sending_price']=intval($sending_price);
                }
            }
            else{
                $array['sending_price']=intval($sending_price);
            }
            $array['sending_time']=intval($sending_time);
        }

        return $array;
    }

}
