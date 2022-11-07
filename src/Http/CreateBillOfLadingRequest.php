<?php


namespace Omniship\Glovo\Http;

use Carbon\Carbon;
use Omniship\Glovo\Client;
use Omniship\Glovo\Http\ShippingQuoteResponse;

class CreateBillOfLadingRequest extends AbstractRequest
{
    /**
     * @return array|mixed
     */
    public function getData()
    {
        $data['description'] = $this->getParameter('content');
        $data['reference'] = [
            'id' => $this->getTransactionId(),
        ];
        $data['addresses'][] =[
            'type' => 'PICKUP',
            'lat' => $this->getSenderAddress()->getLatitude(),
            'lon' => $this->getSenderAddress()->getLongitude(),
            'label' => $this->getSenderAddress()->getNote(),
            'contactPhone' => $this->getSenderAddress()->getPhone(),
            'contactPerson' => $this->getSenderAddress()->getFullName(),
            'instructions' => $this->getOtherParameters('instructions'),
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
            'details' => $this->getReceiverAddress()->getNote(),
            'contactPerson' => $this->getReceiverAddress()->getFullName(),
            'contactPhone' => $this->getReceiverAddress()->getPhone(),
        ];

        return array_filter($data);
    }

    /**
     * @param $data
     * @return CreateBillOfLadingResponse|\Omniship\Interfaces\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendData($data)
    {
        $services = (new Client($this->getPublicKey(), $this->getPrivateKey(), $this->getTestMode()));
        return $this->createResponse($services->SendRequest('POST', '/b2b/orders',$data));
    }

    /**
     * @param $data
     * @return CreateBillOfLadingResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CreateBillOfLadingResponse($this, $data);
    }

}
