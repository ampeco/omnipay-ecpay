<?php

namespace Ampeco\OmnipayEcpay\Message;

use Ampeco\OmnipayEcpay\SDK\ContainsSDK;
use Omnipay\Common\Message\AbstractRequest;

abstract class Request extends AbstractRequest
{
    use ContainsSDK;

    public function setHashKey($value)
    {
        return $this->setParameter('HashKey', $value);
    }

    public function getHashKey()
    {
        return $this->getParameter('HashKey');
    }

    public function setHashIV($value)
    {
        return $this->setParameter('HashIV', $value);
    }

    public function getHashIV()
    {
        return $this->getParameter('HashIV');
    }

    public function setMerchantID($value)
    {
        return $this->setParameter('MerchantID', $value);
    }

    public function getMerchantID()
    {
        return $this->getParameter('MerchantID');
    }

    public function setClientId($value){
        $this->setParameter('client_id', $value);
    }
    public function getClientId(){
        return $this->getParameter('client_id');
    }

    public function setMerchantTradeNo($value){
        $this->setParameter('MerchantTradeNo', $value);
    }
    public function getMerchantTradeNo(){
        return $this->getParameter('MerchantTradeNo');
    }



    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
