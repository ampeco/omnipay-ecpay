<?php


namespace Ampeco\OmnipayEcpay\Message;


class CheckRequest extends Request
{
    
    const TYPE_LOVE_CODE = 'LoveCode';
    const TYPE_MOBILE_BAR_CODE = 'MobileBarCode';

    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }

    public function getType()
    {
        return $this->getParameter('type');
    }

    public function setCode($value)
    {
        return $this->setParameter('code', $value);
    }

    public function getCode()
    {
        return $this->getParameter('code');
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return [
            'type' => $this->getType(),
            'code' => $this->getCode(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $api = $this->getInvoiceApi();
        $method = 'check' . $data['type'];
        $res = $api->$method($data['code']);
        return $this->response = new CheckResponse($this, $res);
    }
}
