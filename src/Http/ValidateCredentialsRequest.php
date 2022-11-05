<?php

namespace Omniship\Glovo\Http;
use Omniship\Glovo\Client;


class ValidateCredentialsRequest extends AbstractRequest
{


    public function getData()
    {
    }

    /**
     * @param $data
     * @return ValidateCredentialsResponse|\Omniship\Interfaces\ResponseInterface
     */
    public function sendData($data)
    {
        $publicKey = $this->getParameter('public_key', $this->getPublicKey());
        $privateKey = $this->getParameter('private_key', $this->getPrivateKey());

        $services = (new Client($publicKey, $privateKey));
        $services = $services->SendRequest('GET', 'b2b/working-areas');
        return $this->createResponse($services);
    }

    /**
     * @param $data
     * @return ValidateCredentialsResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new ValidateCredentialsResponse($this, $data);
    }

}
