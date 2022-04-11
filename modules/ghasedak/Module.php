<?php


namespace Modules\ghasedak;


use App\BaseModule;

class Module extends BaseModule
{
    public function sms_channel_info(){
        return [
            'title'=>'قاصدک',
            'name'=>'ghasedak'
        ];
    }

    public function ghasedak_send_sms($data){
        $mobile_number=$data['mobile_number'];
        $message=$data['message'];
        $api = new GhasedakApi($data['api-key']);
        try{
            if(!empty($data['template'])){
                $api->Verify($mobile_number,1,$data['template'],$message);
            }
            else{
                $api->SendSimple($mobile_number,$message,$data['line_number']);
            }
        }
        catch(\Exception $e)
        {
        }
    }
}
