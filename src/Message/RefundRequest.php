<?php

namespace Ampeco\OmnipayEcpay\Message;

use Ampeco\OmnipayEcpay\SDK\PaymentApi;

class RefundRequest extends Request
{

    public function getData()
    {
        return [
            'transactionReference' => $this->getTransactionReference(),
            'amount'               => intval($this->getAmount()),
            'transactionId'        => $this->getTransactionId(),
        ];
    }

    public function sendData($data)
    {
        $res = $this->getPaymentApi()->updateTransaction(
            PaymentApi::UPDATE_REFUND,
            $data['transactionReference'],
            $data['transactionId'],
            $data['amount']
        );
        return $this->createResponse($res);
    }
}
