<?php

namespace Omniship\Glovo\Http;

use Doctrine\Common\Collections\ArrayCollection;
use Omniship\Glovo\Client;

class ShippingQuoteRequest extends AbstractRequest
{

    /**
     * @return array|mixed
     */
    public function getData()
    {
        $data['description'] = $this->getParameter('content');
        $data['addresses'][] =[
            'type' => 'PICKUP',
            'lat' => $this->getSenderAddress()->getLatitude(),
            'lon' => $this->getSenderAddress()->getLongitude(),
            'label' => $this->getSenderAddress()->getNote(),
        ];
        $addressFull = [];
        if(!empty($this->getReceiverAddress()->getStreet())) {
            $addressFull[] = $this->getReceiverAddress()->getStreet()->getName();
        }
        if(!empty($this->getReceiverAddress()->getStreetNumber())) {
            $addressFull[] = ' '.$this->getReceiverAddress()->getStreetNumber();
        }
        if(!empty($this->getReceiverAddress()->getQuarter())){
            $addressFull[] = ', '.$this->getReceiverAddress()->getQuarter()->getName();
        }
        if(!empty($this->getReceiverAddress()->getBuilding())){
            $addressFull[] = ', '.$this->getReceiverAddress()->getBuilding();
        }
        if(!empty($this->getReceiverAddress()->getEntrance())){
            $addressFull[] = ', '.$this->getReceiverAddress()->getEntrance();
        }
        if(!empty($this->getReceiverAddress()->getFloor())){
            $addressFull[] = ', '.$this->getReceiverAddress()->getFloor();
        }
        $addressFull = implode('', $addressFull);
        $data['addresses'][] =[
            'type' => 'DELIVERY',
            'lat' => $this->getReceiverAddress()->getLatitude(),
            'lon' => $this->getReceiverAddress()->getLongitude(),
            'label' => $addressFull.' ('.$this->getReceiverAddress()->getAddress1().')',
        ];
        return array_filter($data);
    }

    /**
     * @param $data
     * @return ShippingQuoteResponse|\Omniship\Interfaces\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendData($data)
    {
        $services = (new Client($this->getPublicKey(), $this->getPrivateKey(), $this->getTestMode()));
        return $this->createResponse($services->SendRequest('POST', 'b2b/orders/estimate', $data));
    }

    /**
     * @param $data
     * @return ShippingQuoteResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new ShippingQuoteResponse($this, $data);
    }
}
