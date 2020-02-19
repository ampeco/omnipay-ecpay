<?php


namespace Ampeco\OmnipayEcpay\SDK;


trait ContainsSDK
{
    private $merchantMember = null;
    protected function getPaymentApi(){
        if ($this->merchantMember !== null){
            return $this->merchantMember;
        }

        if (method_exists($this, 'getParameters')){
            $params = $this->getParameters();
        } else {
            $params = ['testMode' => true];
        }

        $this->merchantMember = new PaymentApi($params['MerchantID'],$params['HashKey'],$params['HashIV'], $params['testMode']);

        return $this->merchantMember;
    }
}
