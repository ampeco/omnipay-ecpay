<?php

namespace Ampeco\OmnipayEcpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{

    /**
     * Constructor.
     *
     * @param RequestInterface $request the initiating request.
     * @param mixed $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return $this->data['isSuccessful'];
    }
}
