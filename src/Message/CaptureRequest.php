<?php

namespace Ampeco\OmnipayEcpay\Message;

use Ampeco\OmnipayEcpay\SDK\PaymentApi;

class CaptureRequest extends Request
{

    public function getData()
    {
        return [
            'transactionReference' => $this->getTransactionReference(),
            'amount' => $this->getAmountInteger(),
            'transactionId' => $this->getTransactionId(),
        ];
    }

    public function sendData($data)
    {
        $res = $this->getPaymentApi()->updateTransaction(
            PaymentApi::UPDATE_CAPTURE,
            $data['transactionReference'],
            $data['transactionId'],
            $data['amount']
        );
        return $this->createResponse($res);
    }
}
