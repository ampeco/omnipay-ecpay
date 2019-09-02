<?php

namespace Omnipay\Ecpay\Message;

use Omnipay\Common\Item;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class PurchaseResponse extends Response
{
    public function isSuccessful()
    {
        return false;
    }

    /**
     * Does the response require a redirect?
     *
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return empty($this->data['OrderResultURL']) ? '' : $this->data['OrderResultURL'];
    }

    /**
     * Automatically perform any required redirect.
     *
     * This method is meant to be a helper for simple scenarios. If you want to customize the
     * redirection page, just call the getRedirectUrl() and getRedirectData() methods directly.
     *
     * @return void
     */
    public function getRedirectResponse()
    {
        $this->ecpay->Send['ReturnURL'] = $this->data['ReturnURL'];
        $this->ecpay->Send['OrderResultURL'] = $this->data['OrderResultURL'];
        $this->ecpay->Send['MerchantTradeNo'] = $this->data['MerchantTradeNo'];
        $this->ecpay->Send['MerchantTradeDate'] = $this->data['MerchantTradeDate'];
        $this->ecpay->Send['TotalAmount'] = (int) $this->data['TotalAmount'];
        $this->ecpay->Send['TradeDesc'] = $this->data['TradeDesc'];
        $this->ecpay->Send['ChoosePayment'] = $this->data['ChoosePayment'];
        $this->ecpay->Send['Items'] = $this->getItems();

        $output = $this->ecpay->CheckOutString();
        $output = str_replace('<body', '<body onload="document.forms[0].submit();" style="display: none;"', $output);

        return HttpResponse::create($output);
    }

    private function getItems()
    {
        return empty($this->data['Items']) === true
            ? []
            : array_map(function (Item $item) {
                return [
                    'Name' => $item->getName(),
                    'Price' => (int) $item->getPrice(),
                    'Currenty' => '元',
                    'Quantity' => $item->getQuantity(),
                    'URL' => 'dedwed',
                ];
            }, $this->data['Items']->all());
    }
}
