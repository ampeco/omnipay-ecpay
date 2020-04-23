<?php

namespace Ampeco\OmnipayEcpay\Message;

use Omnipay\Common\Message\ResponseInterface;

class CreateCardRequest extends Request
{
    public function setServerReplyUrl($value){
        $this->setParameter('server_reply_url', $value);
    }
    public function setClientRedirectUrl($value){
        $this->setParameter('client_redirect_url', $value);
    }
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return [
            'client_id'           => $this->getParameter('client_id'),
            'amount'              => intval(round($this->getAmount())),
            'description'         => $this->getDescription(),
            'merchantTradeNo'       => $this->getMerchantTradeNo(),
            'server_reply_url'    => $this->getNotifyUrl(),
            'client_redirect_url' => $this->getReturnUrl(),
        ];
    }
    
    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $res = $this->getPaymentApi()->storeCardPostData(
            $data['client_id'],
            $data['merchantTradeNo'],
            $data['amount'],
            $data['description'],
            $data['server_reply_url'],
            $data['client_redirect_url']
        );

        $this->response = new CreateCardResponse(
            $this,
            $res,
            $this->getPaymentApi()->storeCardUrl()
        );
        return $this->response;
    }
}
