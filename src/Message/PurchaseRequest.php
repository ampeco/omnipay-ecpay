<?php

namespace Ampeco\OmnipayEcpay\Message;

use ECPay_PaymentMethod;

class PurchaseRequest extends Request
{
    public function getPaymentMethod()
    {
        return parent::getPaymentMethod() ?: ECPay_PaymentMethod::ALL;
    }

    public function setMerchantTradeDate($value)
    {
        return $this->parameters->get('MerchantTradeDate', $value);
    }

    public function getMerchantTradeDate()
    {
        return $this->parameters->get('MerchantTradeDate') ?: date('Y/m/d H:i:s');
    }

    public function getData()
    {
        return [
            'HashKey' => $this->getHashKey(),
            'HashIV' => $this->getHashIV(),
            'MerchantID' => $this->getMerchantID(),
            'EncryptType' => $this->getEncryptType(),
            'ReturnURL' => $this->getNotifyUrl(),
            'OrderResultURL' => $this->getReturnUrl(),
            'MerchantTradeNo' => $this->getTransactionId(),
            'MerchantTradeDate' => $this->getMerchantTradeDate(),
            'TotalAmount' => $this->getAmount(),
            'TradeDesc' => $this->getDescription(),
            'ChoosePayment' => $this->getPaymentMethod(),
            'Items' => $this->getItems(),
        ];
    }

    public function sendData($data)
    {
        return new PurchaseResponse($this, $data);
    }
}
