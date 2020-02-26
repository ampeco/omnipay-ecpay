<?php

namespace Ampeco\OmnipayEcpay\SDK;

final class Hash
{
    private $hash;
    private $iv;

    /**
     * Hash constructor.
     * @param $hash
     * @param $iv
     */
    public function __construct($hash, $iv)
    {
        $this->hash = $hash;
        $this->iv = $iv;
    }

    public function signSHA256($dictionary, $exemptions = [])
    {
        return $this->sign($dictionary, 'sha256', $exemptions);
    }

    public function signMD5($dictionary, $exemptions = [], $normalize = [])
    {
        return $this->sign($dictionary, 'md5', $exemptions, $normalize);
    }
    public function normalize($macValue){
        // URL Encode編碼
        $macValue = urlencode($macValue);

        // 轉成小寫
        $macValue = strtolower($macValue);

        // 取代為與 dotNet 相符的字元
        $macValue = str_replace('%2d', '-', $macValue);
        $macValue = str_replace('%5f', '_', $macValue);
        $macValue = str_replace('%2e', '.', $macValue);
        $macValue = str_replace('%21', '!', $macValue);
        $macValue = str_replace('%2a', '*', $macValue);
        $macValue = str_replace('%28', '(', $macValue);
        $macValue = str_replace('%29', ')', $macValue);
        return $macValue;
    }


    public function serialize($dictionary)
    {
        unset($dictionary['CheckMacValue']);
        uksort($dictionary, 'strcasecmp');

        // 組合字串
        $macValue = 'HashKey=' . $this->hash;
        foreach ($dictionary as $key => $value) {
            $macValue .= '&' . $key . '=' . $value;
        }

        $macValue .= '&HashIV=' . $this->iv;

        // URL Encode編碼
        $macValue = $this->normalize($macValue);
        return $macValue;
    }

    private function sign($dictionary, $alg, $exemptions = [], $normalize = [])
    {
        $sign = $dictionary;
        foreach ($exemptions as $key) {
            unset($sign[$key]);
        }

        foreach ($normalize as $key){
            $sign[$key] = $this->normalize($dictionary[$key]);
        }

        $serialized = $this->serialize($sign);
        switch ($alg) {
            case 'sha256':
                $res = hash('sha256', $serialized);
                break;

            case 'md5':
            default:
                $res = md5($serialized);
                break;
        }

        return strtoupper($res);
    }
}
