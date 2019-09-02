<?php

namespace Omnipay\Ecpay\Tests;

use Mockery as m;
use Omnipay\Omnipay;
use PHPUnit\Framework\TestCase;
use Omnipay\Common\Http\ClientInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class GatewayTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @test */
    public function it_can_complete_purchase()
    {
        $client = m::spy(ClientInterface::class);
        $gateway = Omnipay::create('Ecpay', $client);

        $_POST = [
            'CustomField1' => '',
            'CustomField2' => '',
            'CustomField3' => '',
            'CustomField4' => '',
            'MerchantID' => '2000132',
            'MerchantTradeNo' => '2821567410556',
            'PaymentDate' => '2019/09/02 15:49:58',
            'PaymentType' => 'Credit_CreditCard',
            'PaymentTypeChargeFee' => '1',
            'RtnCode' => '1',
            'RtnMsg' => 'Succeeded',
            'SimulatePaid' => '0',
            'StoreID' => '',
            'TradeAmt' => '4250',
            'TradeDate' => '2019/09/02 15:49:16',
            'TradeNo' => '1909021549160081',
            'CheckMacValue' => 'E7EC8DDC6C5C51B1A4D8BEA261246066858B38184C55FD3DD3D6DFF53F535A64',
        ];

        $response = $gateway->completePurchase(array_merge($_POST, [
            'HashKey' => '5294y06JbISpM5x9',
            'HashIV' => 'v77hoKGq4kWxNNIS',
            'MerchantID' => '2000132',
            'EncryptType' => '1',
        ]))->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('1', $response->getCode());
        $this->assertEquals('Succeeded', $response->getMessage());
        $this->assertEquals('2821567410556', $response->getTransactionId());
        $this->assertEquals('1909021549160081', $response->getTransactionReference());
    }
}
