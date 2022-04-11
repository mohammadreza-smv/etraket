<?php

namespace Modules\ipgsw\Models;

use Modules\setting\Repository\SettingRepositoryInterface;

/**
 * This is just an example.
 */
class IPGSW
{
    public $PIN;
    public function __construct()
    {
        $repository=app(SettingRepositoryInterface::class);
        $keys=['PIN'];
        $values=$repository->getValues($keys);
        $this->PIN=array_key_exists('PIN',$values) ? $values['PIN'] : '';

    }
    public function pay($amount,$order_id,$callBackUrl)
    {
        $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL";
        $amount=$amount*10;
        $params = array (
            "LoginAccount" => $this->PIN,
            "Amount" => $amount,
            "OrderId" => $order_id,
            "CallBackUrl" => $callBackUrl
        );

        $client = new \SoapClient ( $wsdl_url );

        try {
            $result = $client->SalePaymentRequest ( array (
                "requestData" => $params
            ) );

            if ($result->SalePaymentRequestResult->Token && $result->SalePaymentRequestResult->Status === 0)
            {
                return $result->SalePaymentRequestResult->Token;
            }
            elseif ( $result->SalePaymentRequestResult->Status  != '0')
            {
                return false;
            }
        }
        catch (\Exception $ex ) {
            return false;
        }
    }
    public function Verify($Token,$status,$OrderId,$TerminalNo,$Amount,$RRN)
    {
        $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL";

        $params = array (
            "LoginAccount" => $this->PIN,
            "Token" => $Token
        );
        $client = new \SoapClient ( $wsdl_url );

        try {
            $result = $client->ConfirmPayment ( array (
                "requestData" => $params
            ) );
            return true;
        }
        catch (\Exception $ex ) {
            return false;
        }
    }

}
