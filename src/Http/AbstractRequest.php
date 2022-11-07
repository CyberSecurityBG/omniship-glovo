<?php

namespace Omniship\Glovo\Http;

use Omniship\Interfaces\RequestInterface;
use Omniship\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest implements RequestInterface
{
    /**
     * @return mixed
     */
    public function getBaseUrl(){

        return $this->getParameter('base_url');
    }

    public function setBaseUrl($value){
        return $this->setParameter('base_url', $value);
    }

    public function setPublicKey($value)
    {
        return $this->setParameter('public_key', $value);
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
     * @return mixed
     */
    public function setPrivateKey($value){
        return $this->setParameter('private_key', $value);
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setTestModey($value){
        return $this->setParameter('test_mode', $value);
    }

    /**
     * @return mixed
     */
    public function getTestMode()
    {
        return $this->getParameter('test_mode');
    }

    abstract protected function createResponse($data);

}
