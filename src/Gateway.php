<?php

namespace Ampeco\OmnipayEcpay;

use Ampeco\OmnipayEcpay\Message\AuthorizeRequest;
use Ampeco\OmnipayEcpay\Message\CaptureRequest;
use Ampeco\OmnipayEcpay\Message\CheckRequest;
use Ampeco\OmnipayEcpay\Message\CreateCardRequest;
use Ampeco\OmnipayEcpay\Message\DeleteCardRequest;
use Ampeco\OmnipayEcpay\Message\IssueInvoiceRequest;
use Ampeco\OmnipayEcpay\Message\ListCardsRequest;
use Ampeco\OmnipayEcpay\Message\PurchaseRequest;
use Ampeco\OmnipayEcpay\Message\RefundRequest;
use Ampeco\OmnipayEcpay\Message\VoidRequest;
use Ampeco\OmnipayEcpay\SDK\ContainsSDK;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\NotificationInterface;

/**
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 */
class Gateway extends AbstractGateway
{
    use ContainsSDK;

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

    public function setInvoiceHashKey($value)
    {
        return $this->setParameter('InvoiceHashKey', $value);
    }

    public function getInvoiceHashKey()
    {
        return $this->getParameter('InvoiceHashKey');
    }

    public function setInvoiceHashIV($value)
    {
        return $this->setParameter('InvoiceHashIV', $value);
    }

    public function getInvoiceHashIV()
    {
        return $this->getParameter('InvoiceHashIV');
    }

    public function setInvoiceMerchantID($value)
    {
        return $this->setParameter('InvoiceMerchantID', $value);
    }

    public function getInvoiceMerchantID()
    {
        return $this->getParameter('InvoiceMerchantID');
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
        return 'TWD';
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest(VoidRequest::class, $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return CreateCardRequest|AbstractRequest
     */
    public function createCard(array $parameters)
    {
        return $this->createRequest(CreateCardRequest::class, $parameters);
    }

    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest(DeleteCardRequest::class, $parameters);
    }

    /**
     * @return SDK\Notification|NotificationInterface
     */
    public function acceptNotification()
    {
        return $this->getPaymentApi()->getNotificationsFromPost($_POST);
    }

    public function listCards(array $parameters = array())
    {
        return $this->createRequest(ListCardsRequest::class, $parameters);
    }


    /**
     * @param array $parameters
     * @return IssueInvoiceRequest
     */
    public function issueInvoice(array $parameters = [])
    {
        return $this->createRequest(IssueInvoiceRequest::class, $parameters);
    }

    public function checkRequest(array $parameters = [])
    {
        return $this->createRequest(CheckRequest::class, $parameters);
    }


    public function __call($name, $arguments)
    {
        throw new \BadMethodCallException('Not supported - ' . $name);
    }
}
