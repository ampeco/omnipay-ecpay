<?php


namespace Ampeco\OmnipayEcpay\SDK;


use Carbon\Carbon;

class MerchantMember
{
    use LoadsHttpClient, SignsData;

    private $merchant_id;

    /**
     * @var bool
     */
    private $testMode;

    public function __construct($merchant_id, $hash, $iv, $testMode = false)
    {
        $this->merchant_id = $merchant_id;
        $this->hash = $hash;
        $this->iv = $iv;
        $this->testMode = $testMode;
        $this->setHttpClientOptions(['base_uri' => $this->testMode
            ? 'https://payment-stage.ecpay.com.tw/MerchantMember/'
            : 'https://payment.ecpay.com.tw/MerchantMember/'
        ]);
    }
    public function authCardID($amount, $description)
    {
        $date = Carbon::now();
        $post = [
            'MerchantID' => $this->merchant_id,
            'MerchantTradeNo' => $date->unix(),
            'MerchantTradeDate' => '2020/02/18 16:49:57',//$date->toRfc850String(),
            'TotalAmount' => $amount,
            'TradeDesc' => $description,
            'CardID' => 67557, // TODO
            'stage' => 0, // TODO: Confirm what this is
            'MerchantMemberID' => '3002607OASIS009', // TODO
        ];
        $post = $this->signDataWithSha256($post);
        return $this->validDataWithSha265($this->parseResponse($this->getHttpClient()->post('AuthCardID/V2', $post)));
    }

    public function tradeWithBindingCardIDPostData($clientId, $amount, $description, $server_reply_url, $client_redirect_url){
        $date = Carbon::now();
        $post = [
            'MerchantID' => $this->merchant_id,
            'MerchantTradeNo' => uniqid($date->unix()),
            'MerchantTradeDate' => $date->format('Y/m/d H:i:s'),
            'TotalAmount' => $amount,
            'TradeDesc' => $description,
            'MerchantMemberID' => $this->merchant_id.'-'.$clientId,
            'stage' => 0, // TODO: Confirm what this is
            'ServerReplyURL' => $server_reply_url,
            'ClientRedirectURL' => $client_redirect_url,
        ];
        $post = $this->signDataWithSha256($post);
        return $post;
    }

    public function tradeWithBindingCardIDUrl(){
        return $this->getHttpClient()->getConfig('base_uri').'TradeWithBindingCardID';
    }
}
