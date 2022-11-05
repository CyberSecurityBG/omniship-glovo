<?php
namespace Omniship\Glovo\Http;


use Omniship\Glovo\Client;

class CancelBillOfLadingRequest extends AbstractRequest
{

    /**
     * @return array
     */
    public function getData() {
        $explodeId = explode(' - ', $this->getBolId());
        return $explodeId[0];
    }

    /**
     * @param mixed $data
     * @return CancelBillOfLadingResponse
     */
    public function sendData($data)
    {
        $params = $this->parameters->all();
        $client = (new Client($this->getPublicKey(), $this->getPrivateKey()));
        return $this->createResponse($client->SendRequest('POST', '/b2b/orders/'.$data.'/cancel'));
    }


        /**
     * @param $data
     * @return CancelBillOfLadingResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new CancelBillOfLadingResponse($this, $data);
    }

}
