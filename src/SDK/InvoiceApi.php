<?php


namespace Ampeco\OmnipayEcpay\SDK;


use Carbon\Carbon;

class InvoiceApi
{
    use LoadsHttpClient, SignsData;

    private $merchant_id;

    public function __construct($merchant_id, $hash, $iv, $testMode = false)
    {
        $this->merchant_id = $merchant_id;
        $this->hash = $hash;
        $this->iv = $iv;
        $this->testMode = $testMode;
        $this->setHttpClientOptions([
            'base_uri' => $this->testMode
                ? 'https://einvoice-stage.ecpay.com.tw/'
                : 'https://einvoice.ecpay.com.tw/'
        ]);
    }

    // Fluent interface
    protected $parameters = [];

    public function withCustomer($id, $name, $addr, $phone, $email)
    {
        $chain = clone $this;
        if ($id){
            $chain->parameters['CustomerId'] = $this->merchant_id . $id;
        }
        $chain->parameters['CustomerName'] = $name;
        $chain->parameters['CustomerAddr'] = $addr;
        $chain->parameters['CustomerPhone'] = $phone;
        $chain->parameters['CustomerEmail'] = $email;
        return $chain;
    }

    public function addItem($name, $price, $word, $count = 1, $remark = null)
    {
        $chain = clone $this;

        if (@$chain->parameters['ItemName']) {
            $chain->parameters['ItemName'] .= '|';
        }
        @$chain->parameters['ItemName'] .= $name;

        if (@$chain->parameters['ItemPrice']) {
            $chain->parameters['ItemPrice'] .= '|';
        }
        @$chain->parameters['ItemPrice'] .= $price;

        if (@$chain->parameters['ItemWord']) {
            $chain->parameters['ItemWord'] .= '|';
        }
        @$chain->parameters['ItemWord'] .= $word;

        if (@$chain->parameters['ItemCount']) {
            $chain->parameters['ItemCount'] .= '|';
        }
        @$chain->parameters['ItemCount'] .= $count;

        if ($remark) {
            if (@$chain->parameters['ItemRemark']) {
                $chain->parameters['ItemRemark'] .= '|';
            }
            @$chain->parameters['ItemRemark'] .= $remark;
        }

        if (@$chain->parameters['ItemAmount']) {
            $chain->parameters['ItemAmount'] .= '|';
        }
        @$chain->parameters['ItemAmount'] .= $count * $price;

        return $chain;
    }

    public function forCompany($identifier)
    {
        $chain = clone $this;
        $chain->parameters['CustomerIdentifier'] = $identifier;
        return $chain->withPrint(true);
    }

    public function forMobile($carrierNum)
    {
        $chain = clone $this;
        $chain->parameters['CarruerType'] = 3;
        $chain->parameters['CarruerNum'] = $carrierNum;

        return $chain;
    }

    public function forCitizen($carrierNum)
    {
        $chain = clone $this;
        $chain->parameters['CarruerType'] = 2;
        $chain->parameters['CarruerNum'] = $carrierNum;

        return $chain;
    }

    public function forDonation($code)
    {
        $chain = clone $this;
        $chain->parameters['Donation'] = 1;
        $chain->parameters['LoveCode'] = $code;
        unset($chain->parameters['CustomerId']);
        return $chain->withPrint(false);
    }

    public function withPrint($print)
    {
        $chain = clone $this;

        $chain->parameters['Print'] = $print ? 1 : 0;

        return $chain;
    }

    public function invoiceIssue($relateNumber, $amount)
    {
        $date = Carbon::now();
        $post = $this->parameters;
        $post['TimeStamp'] = $date->unix();
        $post['MerchantID'] = $this->merchant_id;
        $post['RelateNumber'] = $relateNumber;
        $post['TaxType'] = 1;
        $post['SalesAmount'] = $amount;
        $post['InvType'] = 7;

        $post = $this->signDataWithMd5($post, ['ItemName', 'ItemWord', 'ItemRemark'], ['CustomerName', 'CustomerAddr', 'CustomerEmail']);
        return $this->validDataWithMd5(
            $this->parseResponse(
                $this->getHttpClient()->post('Invoice/Issue', $post)
            )
        );
    }

    public function checkMobileBarCode($barCode)
    {
        $date = Carbon::now();
        $post = [
            'TimeStamp'  => $date->unix(),
            'MerchantID' => $this->merchant_id,
            'BarCode'    => $barCode
        ];
        $post = $this->signDataWithMd5($post);
        return $this->validDataWithMd5(
            $this->parseResponse(
                $this->getHttpClient()->post('Query/CheckMobileBarCode', $post)
            )
        );
    }

    public function checkLoveCode($loveCode)
    {
        $date = Carbon::now();
        $post = [
            'TimeStamp'  => $date->unix(),
            'MerchantID' => $this->merchant_id,
            'LoveCode'   => $loveCode
        ];
        $post = $this->signDataWithMd5($post);
        return $this->validDataWithMd5(
            $this->parseResponse(
                $this->getHttpClient()->post('Query/CheckLoveCode', $post)
            )
        );
    }
}
