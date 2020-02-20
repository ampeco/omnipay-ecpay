<?php


namespace Ampeco\OmnipayEcpay\SDK;


use Ampeco\OmnipayEcpay\SDK\Exceptions\InvalidSignatureException;

trait SignsData
{

    private $hash;
    private $iv;

    private function hash(){
        return new Hash($this->hash, $this->iv);
    }

    protected function signDataWithSha256($data){
        $signature = $this->hash()->signSHA256($data);
        $data['CheckMacValue'] = $signature;
        return $data;
    }

    protected function validDataWithSha265($data){
        $claimed_signature = @$data['CheckMacValue'];
        unset($data['CheckMacValue']);
        $actual_signature = $this->hash()->signSHA256($data);
        if ($actual_signature != $claimed_signature){
            throw new InvalidSignatureException('Signature mismatch: '.$claimed_signature.' != '.$actual_signature.' - '.json_encode($data));
        }
        return $data;
    }
}
