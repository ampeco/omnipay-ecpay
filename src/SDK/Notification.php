<?php


namespace Ampeco\OmnipayEcpay\SDK;


use Omnipay\Common\Message\NotificationInterface;

class Notification implements NotificationInterface
{
    private $post;
    private $hashKey;
    private $hashIv;

    public function __construct($post, $hashKey, $hashIv)
    {
        $this->post = $post;
        $this->hashKey = $hashKey;
        $this->hashIv = $hashIv;
    }

    public function isSuccessful()
    {
        return $this->post['RtnCode'] == 1;
    }

    public function getCode()
    {
        return $this->post['RtnCode'];
    }

    public function getMessage()
    {
        return $this->post['RtnMsg'];
    }

    public function getCardId()
    {
        return @$this->post['CardID'];
    }

    public function getTradeId()
    {
        return @$this->post['AllpayTradeNo'];
    }

    public function getCardFirst6()
    {
        return @$this->post['Card6No'];
    }

    public function getCardLast4()
    {
        return @$this->post['Card4No'];
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->post;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        return $this->getTradeId();
    }

    public function getTransactionId()
    {
        return substr($this->post['MerchantTradeNo'], $this->post['MerchantID']);
    }

    /**
     * @inheritDoc
     */
    public function getTransactionStatus()
    {
        if ($this->getCode() == 1){
            return self::STATUS_COMPLETED;
        } else {
            return self::STATUS_FAILED;
        }
    }
}
