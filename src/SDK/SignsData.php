<?php


namespace Ampeco\OmnipayEcpay\SDK;


use Ampeco\OmnipayEcpay\SDK\Exceptions\InvalidSignatureException;

trait SignsData
{

    private $hash;
    private $iv;
    /**
     * @var bool
     */
    private $testMode;

    private function hash()
    {
        return new Hash($this->hash, $this->iv);
    }

    protected function signDataWithSha256($data, $exemptions = [])
    {
        $signature = $this->hash()->signSHA256($data, $exemptions);
        $data['CheckMacValue'] = $signature;
        return $data;
    }

    protected function signDataWithMd5($data, $exemptions = [], $normalize = [])
    {
        $signature = $this->hash()->signMD5($data, $exemptions, $normalize);
        $data['CheckMacValue'] = $signature;
        return $data;
    }

    protected function validData($data, $method = 'signSHA256', $ignoreOnTest=false)
    {
        if ($ignoreOnTest && $this->testMode) {
            return $data; // Signature is missing on testing for some responses
        }
        $claimed_signature = @$data['CheckMacValue'];
        unset($data['CheckMacValue']);
        $actual_signature = call_user_func([$this->hash(), $method], $data);
        if ($actual_signature != $claimed_signature) {
            throw new InvalidSignatureException('Signature mismatch: ' . $claimed_signature . ' != ' . $actual_signature . ' - ' . json_encode($data));
        }
        return $data;
    }

    protected function validDataWithSha265($data, $ignoreOnTest = false)
    {
        return $this->validData($data, 'signSHA256', $ignoreOnTest);
    }

    protected function validDataWithMd5($data, $ignoreOnTest = false)
    {
        return $this->validData($data, 'signMD5', $ignoreOnTest);
    }
}
