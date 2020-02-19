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


    protected function createResponse($data, $isSuccessful=null)
    {
//        if (isset($data['TRANSACTION_ID']) && !isset($data[''])){
//            $data = array_merge($data, [
//                'redirect_url' => $this->fibank->getRedirectUrl($data['TRANSACTION_ID'])
//            ]);
//        }
        if (!is_null($isSuccessful)){
            $data['isSuccessful'] = $isSuccessful;
        }

        return $this->response = new Response($this, $data);
    }


//    public function setEncryptType($value)
//    {
//        return $this->setParameter('EncryptType', $value);
//    }
//
//    public function getEncryptType()
//    {
//        return $this->getParameter('EncryptType');
//    }
}
