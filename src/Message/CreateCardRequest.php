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
    public function setClientId($value){
        $this->setParameter('client_id', $value);
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
            'client_id'      => $this->getParameter('client_id'),
            'amount'      => $this->getAmountInteger(),
            'description' => $this->getDescription(),
            'server_reply_url' => $this->getParameter('server_reply_url'),
            'client_redirect_url' => $this->getParameter('client_redirect_url'),
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
        $data = $this->getMerchantMember()->tradeWithBindingCardIDPostData(
            $data['client_id'],
            $data['amount'],
            $data['description'],
            $data['server_reply_url'],
            $data['client_redirect_url']
        );

        $this->response = new CreateCardResponse($this, $data, $this->getMerchantMember()->tradeWithBindingCardIDUrl());
        return $this->response;
    }
}
