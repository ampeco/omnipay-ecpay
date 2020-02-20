<?php

namespace Ampeco\OmnipayEcpay\Message;

class ListCardsRequest extends Request
{

    public function getData()
    {
        return [
            'clientId' => $this->getClientId(),
        ];
    }

    public function sendData($data)
    {
        $res = $this->getPaymentApi()->queryMemberBinding($data['clientId']);
        if (isset($res['JSonData'])){
            $list = json_decode($res['JSonData'], true);
            if ($list && !isset($list[0])){
                $list = [$list]; // The JSonData contains the card itself it only one is added or a list of cards otherwise
            }
            $res['JSonData'] = $list;
            $res['RtnCode'] = 1;
            $res['RtnMsg'] = 'Success';
        }
        return $this->createResponse($res);
    }
}
