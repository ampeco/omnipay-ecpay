<?php

namespace Ampeco\OmnipayEcpay;

use Ampeco\OmnipayEcpay\Message\CreateCardRequest;
use Ampeco\OmnipayEcpay\Message\PurchaseCompleteRequest;
use Ampeco\OmnipayEcpay\Message\PurchaseRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;

/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
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

    public function getCreateCardAmount()
    {
        return $this->getParameter('createCardAmount');
    }

    public function setCreateCardAmount($value)
    {
        return $this->setParameter('createCardAmount', $value);
    }

    public function getCreateCardCurrency()
    {
        return $this->getParameter('createCardCurrency');
    }

    public function setCreateCardCurrency($value)
    {
        return $this->setParameter('createCardCurrency', $value);
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function acceptNotification(array $parameters = [])
    {
        return $this->completePurchase($parameters);
    }

    public function completePurchase(array $parameters)
    {
        return $this->createRequest(PurchaseCompleteRequest::class, $parameters);
    }


    /**
     * @param array $parameters
     * @return CreateCardRequest|AbstractRequest
     */
    public function createCard(array $parameters)
    {
        return $this->createRequest(CreateCardRequest::class, $parameters);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }
}
