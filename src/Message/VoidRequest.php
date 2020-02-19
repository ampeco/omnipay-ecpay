<?php

namespace Ampeco\OmnipayEcpay\Message;

use Ampeco\OmnipayEcpay\SDK\PaymentApi;

class VoidRequest extends Request
{

    public function getData()
    {
        return [
            'transactionReference' => $this->getTransactionReference(),
            'amount' => $this->getAmountInteger(),
            'merchantTradeNo' => $this->getMerchantTradeNo(),
        ];
    }

    public function sendData($data)
    {
        $res = $this->getPaymentApi()->updateTransaction(
            PaymentApi::UPDATE_DELETE,
            $data['transactionReference'],
            $data['merchantTradeNo'],
            $data['amount']
        );
        return $this->createResponse($res);
    }
}
