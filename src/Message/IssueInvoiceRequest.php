<?php

namespace Ampeco\OmnipayEcpay\Message;

use Ampeco\OmnipayEcpay\SDK\InvoiceApi;
use Omnipay\Common\ItemInterface;

class IssueInvoiceRequest extends Request
{

    const INVOICE_TYPE_DONATION = 'Donation';
    const INVOICE_TYPE_COMPANY = 'Company';
    const INVOICE_TYPE_MOBILE = 'Mobile';
    const INVOICE_TYPE_CITIZEN = 'Citizen';
    const INVOICE_TYPE_GREEN_WORLD = 'GreenWorld';

    public function getData()
    {
        return [
            'amount'                => $this->getAmount(),
            'transactionId'         => $this->getMerchantTradeNo(),
            'clientId'              => $this->getClientId(),
            'clientName'            => $this->getClientName(),
            'clientAddr'            => $this->getClientAddr(),
            'clientPhone'           => $this->getClientPhone(),
            'clientEmail'           => $this->getClientEmail(),
            'invoiceType'           => $this->getInvoiceType(),
            'invoiceTypeIdentifier' => $this->getInvoiceTypeIdentifier(),
            'items'                 => $this->getItems(),
        ];
    }


    public function sendData($data)
    {
        /**
         * @var InvoiceApi $api
         */
        $api = $this->getInvoiceApi();

        // Add the customer data
        $api = $api->withCustomer(
            $data['clientId'],
            $data['clientName'],
            $data['clientAddr'],
            $data['clientPhone'],
            $data['clientEmail']
        );

        // Add the company/Greenworld/Carrier/Donation/Citizen data
        $method = "for" . $data['invoiceType'];
        $api = $api->$method($data['invoiceTypeIdentifier']);

        // Add the purchased item information
        foreach ($data['items'] as $item) {
            /**
             * @var ItemInterface $item
             */
            // TODO: Do not hard-code the "word" component
            $api = $api->addItem(
                $item->getName(),
                $this->getAmount(),
                '式',
                $item->getQuantity(),
                $item->getDescription()
            );
        }

        $res = $api->invoiceIssue($data['transactionId'], $data['amount']);

        return $this->createResponse($res);
    }


    public function setClientName($value)
    {
        return $this->setParameter('client_name', $value);
    }

    public function getClientName()
    {
        return $this->getParameter('client_name');
    }

    public function setClientAddr($value)
    {
        return $this->setParameter('client_addr', $value);
    }

    public function getClientAddr()
    {
        return $this->getParameter('client_addr');
    }

    public function setClientPhone($value)
    {
        return $this->setParameter('client_phone', $value);
    }

    public function getClientPhone()
    {
        return $this->getParameter('client_phone');
    }

    public function setClientEmail($value)
    {
        return $this->setParameter('client_email', $value);
    }

    public function getClientEmail()
    {
        return $this->getParameter('client_email');
    }

    public function setInvoiceType($value)
    {
        return $this->setParameter('invoice_type', $value);
    }

    public function getInvoiceType()
    {
        return $this->getParameter('invoice_type');
    }

    public function setInvoiceTypeIdentifier($value)
    {
        return $this->setParameter('invoice_type_identifier', $value);
    }

    public function getInvoiceTypeIdentifier()
    {
        return $this->getParameter('invoice_type_identifier');
    }
}
