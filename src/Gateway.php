<?php

namespace Omnipay\Ecpay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Ecpay\Message\PurchaseRequest;
use Omnipay\Ecpay\Message\PurchaseCompleteRequest;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Ecpay';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'HashKey' => '5294y06JbISpM5x9',
            'HashIV' => 'v77hoKGq4kWxNNIS',
            'MerchantID' => '2000132',
            'EncryptType' => '1',
        ];
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters)
    {
        return $this->createRequest(PurchaseCompleteRequest::class, $parameters);
    }
}
