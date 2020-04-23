<?php

namespace Ampeco\OmnipayEcpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{

    /**
     * Constructor.
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return @$this->data['RtnCode'] == 1;
    }

    public function getCode()
    {
        return @$this->data['RtnCode'];
    }

    public function getMessage()
    {
        return @$this->data['RtnMsg'];
    }
    public function getTransactionReference()
    {
        return @$this->data['AllpayTradeNo'] ?: @$this->data['TradeNo'];
    }

    public function getTransactionId()
    {
        return substr(@$this->data['MerchantTradeNo'], $this->getRequest()->getTransactionPrefix() ?: $this->getRequest()->getMerchantID());
    }
}
