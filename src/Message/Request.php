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

    public function getTransactionPrefix()
    {

        return $this->getParameter('TransactionPrefix');
    }

    public function setTransactionPrefix($value)
    {
        return $this->setParameter('TransactionPrefix', $value);
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

    public function setClientId($value)
    {
        $this->setParameter('client_id', $value);
    }

    public function getClientId()
    {
        return $this->getParameter('client_id');
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
