<?php

namespace Ampeco\OmnipayEcpay\Message;

use Omnipay\Common\Message\ResponseInterface;

class DeleteCardRequest extends Request
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return [
            'cardReference' => $this->getCardReference(),
            'clientId' => $this->getClientId(),
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
        $response = $this->getPaymentApi()->deleteCard($data['cardReference'], $data['clientId']);

        return $this->createResponse($response);
    }
}
