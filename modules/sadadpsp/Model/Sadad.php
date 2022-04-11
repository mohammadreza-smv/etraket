<?php


namespace Modules\sadadpsp\Model;


use Modules\setting\Repository\SettingRepositoryInterface;
use function Complex\theta;

class Sadad
{
    protected $merchantId;

    protected $terminalId;

    protected $terminalKey;

    public function __construct()
    {
        $repository=app(SettingRepositoryInterface::class);
        $keys=['sadad_merchantId','sadad_terminalId','sadad_terminalKey'];
        $values=$repository->getValues($keys);
        $this->merchantId=array_key_exists('sadad_merchantId',$values) ? $values['sadad_merchantId'] : '';
        $this->terminalId=array_key_exists('sadad_terminalId',$values) ? $values['sadad_terminalId'] : '';
        $this->terminalKey=array_key_exists('sadad_terminalKey',$values) ? $values['sadad_terminalKey'] : '';
    }

    public function pay($amount,$orderId,$callbackURL=null){
        $CallbackURL =$callbackURL ? $callbackURL : url('order/verify');
        $LocalDateTime=date("m/d/Y g:i:s a");
        $TerminalId=$this->terminalId;
        $key=$this->terminalKey;
        $SignData=$this->encrypt_pkcs7("$TerminalId;$orderId;$amount","$key");

        $data = array('TerminalId'=>$TerminalId,
            'MerchantId'=>$this->merchantId,
            'Amount'=>$amount,
            'SignData'=> $SignData,
            'ReturnUrl'=>$callbackURL,
            'LocalDateTime'=>$LocalDateTime,
            'OrderId'=>$orderId);
        $str_data = json_encode($data);
        $res=$this->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest',$str_data);
        $arrres=json_decode($res);
        if($arrres->ResCode==0)
        {
            return $arrres->Token;
        }
        else{
            return false;
        }
    }

    public function verify($price,$token,$ResCode){
        $result=['status'=>'error'];
        if($ResCode==0){
            $sign=$this->encrypt_pkcs7($token,$this->terminalKey);
            $verifyData = array('Token'=>$token,'SignData'=>$sign);
            $str_data = json_encode($verifyData);
            $res=$this->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Advice/Verify',$str_data);
            $arrres=json_decode($res);
            if($arrres->ResCode!=-1 && $arrres->ResCode==0)
            {
                $result['status']='ok';
                $result['SystemTraceNo']=$arrres->SystemTraceNo;
            }
        }
        return $result;
    }

    public function encrypt_pkcs7($str, $key)
    {
        $key = base64_decode($key);
        $ciphertext = OpenSSL_encrypt($str,"DES-EDE3", $key, OPENSSL_RAW_DATA);
        return base64_encode($ciphertext);
    }

    public function CallAPI($url, $data = false)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
