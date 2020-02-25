<?php


namespace Ampeco\OmnipayEcpay\SDK;


trait ContainsSDK
{
    private $paymentApi = null;
    private $invoiceApi = null;

    protected function getPaymentApi()
    {
        if ($this->paymentApi !== null) {
            return $this->paymentApi;
        }

        if (method_exists($this, 'getParameters')) {
            $params = $this->getParameters();
        } else {
            $params = ['testMode' => true];
        }

        $this->paymentApi = new PaymentApi($params['MerchantID'], $params['HashKey'], $params['HashIV'],
            $params['testMode']);

        return $this->paymentApi;
    }

    protected function getInvoiceApi()
    {
        if ($this->invoiceApi !== null) {
            return $this->invoiceApi;
        }

        if (method_exists($this, 'getParameters')) {
            $params = $this->getParameters();
        } else {
            $params = ['testMode' => true];
        }

        $this->invoiceApi = new InvoiceApi(
            $params['InvoiceMerchantID'],
            $params['InvoiceHashKey'],
            $params['InvoiceHashIV'],
            $params['testMode']
        );

        return $this->invoiceApi;
    }


}
