<?php


namespace Ampeco\OmnipayEcpay\SDK;


trait ContainsSDK
{
    private $paymentApi = null;
    private $invoiceApi = null;
    protected ?HttpClient $mockClient = null;

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

        $this->paymentApi = new PaymentApi(
            $params['MerchantID'],
            $params['HashKey'],
            $params['HashIV'],
            $params['testMode'],
            $this->httpClient,
        );

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
            $params['testMode'],
            $params['productionBaseURI'] ?? null,
            $params['testingBaseURI'] ?? null,
            $this->httpClient,
        );

        return $this->invoiceApi;
    }

    public function setMockClient($client)
    {
        $this->mockClient = $client;
    }

    public function setProductionBaseURI($value)
    {
        if(method_exists($this, 'setParameter')) {
            return $this->setParameter('productionBaseURI', $value);
        }
        return $this;
    }

    public function getProductionBaseURI()
    {
        return method_exists($this, 'getParameter')
            ? $this->getParameter('productionBaseURI')
            : null;
    }

    public function setTestingBaseURI($value)
    {
        if(method_exists($this, 'setParameter')) {
            return $this->setParameter('testingBaseURI', $value);
        }
        return $this;
    }

    public function getTestingBaseURI()
    {
        return method_exists($this, 'getParameter')
            ? $this->getParameter('testingBaseURI')
            : null;
    }
}
