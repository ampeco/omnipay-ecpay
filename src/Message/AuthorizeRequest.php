<?php

namespace Ampeco\OmnipayEcpay\Message;

class AuthorizeRequest extends Request
{

    public function getData()
    {
        return [
            'cardReference' => $this->getCardReference(),
            'clientId'      => $this->getClientId(),
            'amount'        => intval(round($this->getAmount())),
            'description'   => $this->getDescription(),
            'transactionId' => $this->getTransactionId(),
        ];
    }

    public function sendData($data)
    {
        $res = $this->getPaymentApi()->authorizeViaStoredCard(
            $data['transactionId'], $data['cardReference'],$data['clientId'], $data['amount'], $data['description']
        );
        return $this->createResponse($res);
    }
}
