<?php

namespace Omnipay\Ecpay\Message;

use ECPay_AllInOne;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

abstract class Response extends AbstractResponse
{
    protected $ecpay;

    /**
     * Constructor.
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->setupEcpay();
    }

    private function setupEcpay()
    {
        $this->ecpay = new ECPay_AllInOne();
        $this->ecpay->HashIV = $this->data['HashIV'];
        $this->ecpay->HashKey = $this->data['HashKey'];
        $this->ecpay->MerchantID = $this->data['MerchantID'];
        $this->ecpay->EncryptType = $this->data['EncryptType'];

        $this->ecpay->ServiceURL = $this->data['MerchantID'] !== '2000132'
            ? 'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5'
            : 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';
    }
}
