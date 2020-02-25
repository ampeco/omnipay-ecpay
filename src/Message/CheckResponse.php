<?php


namespace Ampeco\OmnipayEcpay\Message;


class CheckResponse extends Response
{
    
    public function exists()
    {
        return $this->getData()['IsExist'] == 'Y';
    }
}
