<?php

namespace Modules\sms;

use App\BaseModule;

class Module extends BaseModule
{
    public function sms_channel_info(){
        return [
            'title'=>'sms.ir',
            'name'=>'smsIR'
        ];
    }

    public function smsIR_send_sms($data){
        $mobile_number=$data['mobile_number'];
        $message=$data['message'];
        $api =$data['api-key'];
        $line =$data['line'];
        try{
            $apiUrl = "https://ws.sms.ir/";
            $APIKey =$api[0];
            $SecretKey =$api[1];
            if(!empty($data['template'])){
                $api=explode('---',$api);
                if(sizeof($api)==2)
                {
                    $data = array(
                        "Mobile" => $mobile_number,
                        "TemplateId" => intval($data['template'])
                    );
                    if(is_array($message))
                    {
                        $data['ParameterArray']=array();
                        $i=1;
                        foreach ($message as $key=>$value)
                        {
                            $data['ParameterArray'][$key]=[
                                'Parameter'=>'code'.$i,
                                'ParameterValue'=>$value
                            ];
                            $i++;
                        }
                    }
                    else{
                        $data['ParameterArray']=array(
                            array(
                                "Parameter" => "code1",
                                "ParameterValue" => strval($message)
                            )
                        );
                    }


                    $SmsIR_UltraFastSend = new SmsIRUltraFastSend($APIKey, $SecretKey, $apiUrl);
                    $SmsIR_UltraFastSend->ultraFastSend($data);

                }
            }
            else{
                $MobileNumbers = array($mobile_number);
                $messages = array($message);
                @$SendDateTime = date("Y-m-d")."T".date("H:i:s");

                $SmsIR_SendMessage = new SmsIRSendMessage($api,$SecretKey,$line);
                $SmsIR_SendMessage->SendMessage($MobileNumbers,$messages,$SendDateTime);
            }
        }
        catch(\Exception $e)
        {
        }
    }
}
