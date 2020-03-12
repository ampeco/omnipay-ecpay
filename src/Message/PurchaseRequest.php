<?php

namespace Ampeco\OmnipayEcpay\Message;

use Ampeco\OmnipayEcpay\SDK\PaymentApi;

class PurchaseRequest extends Request
{

    public function getData()
    {
        return [
            'cardReference' => $this->getCardReference(),
            'clientId'      => $this->getClientId(),
            'amount'        => $this->getAmount(),
            'description'   => $this->getDescription(),
            'transactionId' => $this->getTransactionId(),
        ];
    }

    public function sendData($data)
    {
        $res = $this->getPaymentApi()->authorizeViaStoredCard(
            $data['transactionId'], $data['cardReference'],$data['clientId'], $data['amount'], $data['description']
        );
        $authResponse = new Response($this, $res);
        $this->response = $authResponse;
        if ($authResponse->isSuccessful()){
            $this->getPaymentApi()->updateTransaction(
                PaymentApi::UPDATE_CAPTURE,
                $authResponse->getTransactionReference(),
                $data['transactionId'],
                $data['amount']
            );
        }
        return $authResponse;
    }
}
