<?php

namespace Omniship\Glovo;

use Omniship\Common\AbstractGateway;
use Omniship\Glovo\Client;
use Omniship\Glovo\Http\CancelBillOfLadingRequest;
use Omniship\Glovo\Http\CreateBillOfLadingRequest;
use Omniship\Glovo\Http\ShippingQuoteRequest;
use Omniship\Glovo\Http\ValidateCredentialsRequest;

class Gateway extends AbstractGateway
{

    private $name = 'Glovo';
    protected $client;
    const TRACKING_URL = '';

    /**
     * @return stringc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'public_key' => '',
            'private_key' => '',
        );
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->getParameter('public_key');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setPublicKey($value)
    {
        return $this->setParameter('public_key', $value);
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }

    /**
     * @return Gateway
     */
    public function setPrivateKey($value)
    {
        return $this->setParameter('private_key', $value);
    }

    /**
     * @return mixed
     */
    public function getTestMode()
    {
        return $this->getParameter('test_mode');
    }

    /**
     * @return Gateway
     */
    public function setTestMode($value)
    {
        return $this->setParameter('test_mode', $value);
    }


    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client($this->getPublicKey(), $this->getPrivateKey(), $this->getTestMode());
        }

        return $this->client;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndpoint($value)
    {
        return $this->setParameter('endpoint', $value);
    }

    public function supportsValidateCredentials()
    {
        return true;
    }


    public function validateCredentials(array $parameters = [])
    {
        return $this->createRequest(ValidateCredentialsRequest::class, $parameters);
    }


    public function getQuotes($parameters = [])
    {
        if ($parameters instanceof ShippingQuoteRequest) {
            return $parameters;
        }
        if (!is_array($parameters)) {
            $parameters = [];
        }
        return $this->createRequest(ShippingQuoteRequest::class, $this->getParameters() + $parameters);
    }

    public function supportsCashOnDelivery()
    {
        return true;
    }

    public function supportsCreateBillOfLading()
    {
        return true;
    }

    public function createBillOfLading($parameters = [])
    {
        if ($parameters instanceof CreateBillOfLadingRequest) {
            return $parameters;
        }
        if (!is_array($parameters)) {
            $parameters = [];
        }
        return $this->createRequest(CreateBillOfLadingRequest::class, $this->getParameters() + $parameters);
    }

    public function getPdf($bol_id)
    {
        return $this->createRequest(GetPdfRequest::class, $this->setBolId($bol_id)->getParameters());
    }

    public function trackingUrl($parcel_id)
    {
        return sprintf(static::TRACKING_URL, $parcel_id);
    }

    public function cancelBillOfLading($bol_id, $cancelComment = null)
    {
        $this->setBolId($bol_id);
        return $this->createRequest(CancelBillOfLadingRequest::class, $this->getParameters());
    }
}
