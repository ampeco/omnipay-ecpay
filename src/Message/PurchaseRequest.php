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
            'amount'        => intval(round($this->getAmount())),
            'description'   => $this->getDescription(),
            'merchantTradeNo' => $this->getMerchantTradeNo(),
        ];
    }

    public function sendData($data)
    {
        $authRes = $this->getPaymentApi()->authorizeViaStoredCard(
            $data['merchantTradeNo'], $data['cardReference'],$data['clientId'], $data['amount'], $data['description']
        );
        $authResponse = new Response($this, $authRes);
        $this->response = $authResponse;

        if ($authResponse->isSuccessful()) {
            $captureRes = $this->getPaymentApi()->updateTransaction(
                PaymentApi::UPDATE_CAPTURE,
                $authResponse->getTransactionReference(),
                $data['merchantTradeNo'],
                $data['amount']
            );

            return new Response($this, $captureRes);
        }

        return $authResponse;
    }
}
