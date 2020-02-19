<?php


namespace Ampeco\OmnipayEcpay\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class CreateCardResponse extends AbstractResponse implements RedirectResponseInterface
{
    private $redirectUrl;

    public function __construct(RequestInterface $request, $data, $redirectUrl)
    {
        parent::__construct($request, $data);
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return true;
    }

    public function isRedirect()
    {
        return true;
    }
    public function getRedirectData()
    {
        return $this->data;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

}
