<?php

namespace Modules\ZarinPalGateway;

use Modules\setting\Repository\SettingRepositoryInterface;

class ZarinPal{
    protected $MerchantID;

    public function __construct()
    {
        $repository=app(SettingRepositoryInterface::class);
        $this->MerchantID=$repository->get_value('MerchantID');
    }

    public function pay($amount,$callbackURL){
        $Description = 'توضیحات تراکنش تستی';
        $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentRequest(
            [
                'MerchantID' =>$this->MerchantID,
                'Amount' => $amount,
                'Description' => $Description,
                'CallbackURL' => $callbackURL,
            ]
        );
        if ($result->Status == 100) {
            return $result->Authority;
        }
        else {
            return  false;
        }
    }

    public function verify($amount,$Authority){
        $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentVerification(
            [
                'MerchantID' => $this->MerchantID,
                'Authority' => $Authority,
                'Amount' => $amount,
            ]
        );
        if ($result->Status == 100) {
            return $result->RefID;
        } else {
            return  false;
        }
    }
}
