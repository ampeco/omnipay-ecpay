<?php

namespace Ampeco\OmnipayEcpay\Message;

use Ampeco\OmnipayEcpay\SDK\PaymentApi;

class PurchaseRequest extends Request
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
        $authResponse = new Response($this, $res);
        if ($authResponse->isSuccessful()){
            $res = $this->getPaymentApi()->updateTransaction(
                PaymentApi::UPDATE_CAPTURE,
                $authResponse->getTransactionReference(),
                $data['merchantTradeNo'],
                $data['amount']
            );
            return $this->createResponse($res);
        } else {
            $this->response = $authResponse;
            return $authResponse;
        }
    }
}
