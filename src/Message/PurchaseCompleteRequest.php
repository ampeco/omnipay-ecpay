<?php

namespace Omnipay\Ecpay\Message;

class PurchaseCompleteRequest extends Request
{
    public function setCustomField1($value)
    {
        return $this->parameters->set('CustomField1', $value);
    }

    public function getCustomField1()
    {
        return $this->parameters->get('CustomField1');
    }

    public function setCustomField2($value)
    {
        return $this->parameters->set('CustomField2', $value);
    }

    public function getCustomField2()
    {
        return $this->parameters->get('CustomField2');
    }

    public function setCustomField3($value)
    {
        return $this->parameters->set('CustomField3', $value);
    }

    public function getCustomField3()
    {
        return $this->parameters->get('CustomField3');
    }

    public function setCustomField4($value)
    {
        return $this->parameters->set('CustomField4', $value);
    }

    public function getCustomField4()
    {
        return $this->parameters->get('CustomField4');
    }

    public function setMerchantTradeNo($value)
    {
        return $this->parameters->set('MerchantTradeNo', $value);
    }

    public function getMerchantTradeNo()
    {
        return $this->parameters->get('MerchantTradeNo');
    }

    public function setPaymentDate($value)
    {
        return $this->parameters->set('PaymentDate', $value);
    }

    public function getPaymentDate()
    {
        return $this->parameters->get('PaymentDate');
    }

    public function setPaymentType($value)
    {
        return $this->parameters->set('PaymentType', $value);
    }

    public function getPaymentType()
    {
        return $this->parameters->get('PaymentType');
    }

    public function setPaymentTypeChargeFee($value)
    {
        return $this->parameters->set('PaymentTypeChargeFee', $value);
    }

    public function getPaymentTypeChargeFee()
    {
        return $this->parameters->get('PaymentTypeChargeFee');
    }

    public function setRtnCode($value)
    {
        return $this->parameters->set('RtnCode', $value);
    }

    public function getRtnCode()
    {
        return $this->parameters->get('RtnCode');
    }

    public function setRtnMsg($value)
    {
        return $this->parameters->set('RtnMsg', $value);
    }

    public function getRtnMsg()
    {
        return $this->parameters->get('RtnMsg');
    }

    public function setSimulatePaid($value)
    {
        return $this->parameters->set('SimulatePaid', $value);
    }

    public function getSimulatePaid()
    {
        return $this->parameters->get('SimulatePaid');
    }

    public function setStoreID($value)
    {
        return $this->parameters->set('StoreID', $value);
    }

    public function getStoreID()
    {
        return $this->parameters->get('StoreID');
    }

    public function setTradeAmt($value)
    {
        return $this->parameters->set('TradeAmt', $value);
    }

    public function getTradeAmt()
    {
        return $this->parameters->get('TradeAmt');
    }

    public function setTradeDate($value)
    {
        return $this->parameters->set('TradeDate', $value);
    }

    public function getTradeDate()
    {
        return $this->parameters->get('TradeDate');
    }

    public function setTradeNo($value)
    {
        return $this->parameters->set('TradeNo', $value);
    }

    public function getTradeNo()
    {
        return $this->parameters->get('TradeNo');
    }

    public function setCheckMacValue($value)
    {
        return $this->parameters->set('CheckMacValue', $value);
    }

    public function getCheckMacValue()
    {
        return $this->parameters->get('CheckMacValue');
    }

    public function getData()
    {
        return [
            'CustomField1' => $this->getCustomField1(),
            'CustomField2' => $this->getCustomField2(),
            'CustomField3' => $this->getCustomField3(),
            'CustomField4' => $this->getCustomField4(),
            'MerchantID' => $this->getMerchantID(),
            'MerchantTradeNo' => $this->getMerchantTradeNo(),
            'PaymentDate' => $this->getPaymentDate(),
            'PaymentType' => $this->getPaymentType(),
            'PaymentTypeChargeFee' => $this->getPaymentTypeChargeFee(),
            'RtnCode' => $this->getRtnCode(),
            'RtnMsg' => $this->getRtnMsg(),
            'SimulatePaid' => $this->getSimulatePaid(),
            'StoreID' => $this->getStoreID(),
            'TradeAmt' => $this->getTradeAmt(),
            'TradeDate' => $this->getTradeDate(),
            'TradeNo' => $this->getTradeNo(),
            'CheckMacValue' => $this->getCheckMacValue(),
            'HashKey' => $this->getHashKey(),
            'HashIV' => $this->getHashIV(),
            'EncryptType' => $this->getEncryptType(),
        ];
    }

    public function sendData($data)
    {
        return new PurchaseCompleteResponse($this, $data);
    }
}
