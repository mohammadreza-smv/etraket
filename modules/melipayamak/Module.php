<?php

namespace Modules\melipayamak;

use App\BaseModule;

class Module extends BaseModule
{
    public function sms_channel_info(){
        return [
            'title'=>'ملی پیامک',
            'name'=>'melipayamak'
        ];
    }

    public function melipayamak_send_sms($data){
        $mobile_number=$data['mobile_number'];
        $message=$data['message'];
        $api=explode('---',$data['api-key']);
        if(is_array($message)){
            $text=$message;
        }
        else{
            $text=[$message];
        }
        if(sizeof($api)===2){
            $username=$api[0];
            $password=$api[1];
            if(!empty($data['template'])){
                $sms = new \SoapClient("http://api.payamak-panel.com/post/Send.asmx?wsdl",
                    array("encoding"=>"UTF-8"));
                $data = array(
                    "username"=>$username,
                    "password"=>$password,
                    "text"=>$text,
                    "to"=>$mobile_number,
                    "bodyId"=>$data['template']);
               $sms->SendByBaseNumber($data)->SendByBaseNumberResult;
            }
        }
    }
}
