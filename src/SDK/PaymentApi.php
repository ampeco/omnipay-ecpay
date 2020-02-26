<?php


namespace Ampeco\OmnipayEcpay\SDK;


use Carbon\Carbon;

class PaymentApi
{
    use LoadsHttpClient, SignsData;

    private $merchant_id;


    public function __construct($merchant_id, $hash, $iv, $testMode = false)
    {
        $this->merchant_id = $merchant_id;
        $this->hash = $hash;
        $this->iv = $iv;
        $this->testMode = $testMode;
        $this->setHttpClientOptions(['base_uri' => $this->testMode
            ? 'https://payment-stage.ecpay.com.tw/'
            : 'https://payment.ecpay.com.tw/'
        ]);
    }
    public function authorizeViaStoredCard($merchantTradeNo, $cardId, $clientId, $amount, $description)
    {
        $date = Carbon::now();
        $post = [
            'MerchantID' => $this->merchant_id,
            'MerchantTradeNo' => $this->merchant_id.$merchantTradeNo,
            'MerchantTradeDate' => $date->format('Y/m/d H:i:s'),
            'TotalAmount' => $amount,
            'TradeDesc' => $description,
            'CardID' => $cardId,
            'stage' => 0,
            'MerchantMemberID' => $this->merchant_id.$clientId,
        ];
        $post = $this->signDataWithSha256($post);
        return $this->validDataWithSha265(
            $this->parseResponse(
                $this->getHttpClient()->post('MerchantMember/AuthCardID/V2', $post)
            )
        );
    }

    public function storeCardPostData($clientId, $merchantTradeNo, $amount, $description, $server_reply_url, $client_redirect_url){
        $date = Carbon::now();
        $post = [
            'MerchantID' => $this->merchant_id,
            'MerchantTradeNo' => $this->merchant_id.$merchantTradeNo,
            'MerchantTradeDate' => $date->format('Y/m/d H:i:s'),
            'TotalAmount' => $amount,
            'TradeDesc' => $description,
            'MerchantMemberID' => $this->merchant_id.$clientId,
            'stage' => 0,
            'ServerReplyURL' => $server_reply_url,
            'ClientRedirectURL' => $client_redirect_url,
        ];
        $post = $this->signDataWithSha256($post);
        return $post;
    }

    public function storeCardUrl(){
        return $this->getHttpClient()->getConfig('base_uri').'MerchantMember/TradeWithBindingCardID';
    }

    public function queryMemberBinding($clientId){
        $post = [
            'MerchantID' => $this->merchant_id,
            'MerchantMemberID' => $this->merchant_id.$clientId,
        ];
        $post = $this->signDataWithSha256($post);
        return $this->validDataWithSha265($this->parseResponse($this->getHttpClient()->post('MerchantMember/QueryMemberBinding', $post)));
    }

    public function deleteCard($cardId, $clientId){
        $post = [
            'MerchantID' => $this->merchant_id,
            'MerchantMemberID' => $this->merchant_id.$clientId,
            'CardID' => $cardId,
        ];
        $post = $this->signDataWithSha256($post);
        return $this->validDataWithSha265($this->parseResponse($this->getHttpClient()->post('MerchantMember/DeleteCardID', $post)));
    }

    const UPDATE_CAPTURE = 'C';
    const UPDATE_REFUND = 'R';
    const UPDATE_CANCEL = 'E';
    const UPDATE_DELETE = 'N';

    public function updateTransaction($action, $tradeNo, $merchantTradeNo, $amount){
        $post = [
            'MerchantID' => $this->merchant_id,
            'MerchantTradeNo' => $this->merchant_id.$merchantTradeNo,
            'TradeNo' => $tradeNo,
            'Action' => $action,
            'TotalAmount' => $amount,
        ];
        $post = $this->signDataWithSha256($post);
        return $this->validDataWithSha265(
            $this->parseResponse($this->getHttpClient()->post('CreditDetail/DoAction', $post)),
            true
        );
    }

    public function getNotificationsFromPost($post){
        $post = $this->validDataWithSha265($post);
        return new Notification($post, $this->hash, $this->iv);
    }
}
