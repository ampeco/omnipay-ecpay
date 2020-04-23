<?php

namespace Ampeco\OmnipayEcpay\Message;

use Ampeco\OmnipayEcpay\SDK\PaymentApi;

class CaptureRequest extends Request
{

    public function getData()
    {
        return [
            'transactionReference' => $this->getTransactionReference(),
            'amount'               => intval(round($this->getAmount())),
            'merchantTradeNo' => $this->getMerchantTradeNo(),
        ];
    }

    public function sendData($data)
    {
        $res = $this->getPaymentApi()->updateTransaction(
            PaymentApi::UPDATE_CAPTURE,
            $data['transactionReference'],
            $data['merchantTradeNo'],
            $data['amount']
        );
        return $this->createResponse($res);
    }
}
