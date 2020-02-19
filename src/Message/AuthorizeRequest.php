<?php

namespace Ampeco\OmnipayEcpay\Message;

class AuthorizeRequest extends Request
{

    public function getData()
    {
        return [
            'cardReference' => $this->getCardReference(),
            'clientId' => $this->getClientId(),
            'amount' => $this->getAmountInteger(),
            'description' => $this->getDescription(),
            'merchantTradeNo' => $this->getMerchantTradeNo(),
        ];
    }

    public function sendData($data)
    {
        $res = $this->getPaymentApi()->authorizeViaStoredCard(
            $data['merchantTradeNo'], $data['cardReference'],$data['clientId'], $data['amount'], $data['description']
        );
        return $this->createResponse($res);
    }
}
