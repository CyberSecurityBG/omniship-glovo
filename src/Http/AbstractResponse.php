<?php


namespace Omniship\Glovo\Http;

use Omniship\Evropat\Client;
use Omniship\Message\AbstractResponse AS BaseAbstractResponse;

class AbstractResponse extends BaseAbstractResponse
{

    protected $error;

    protected $errorCode;

    protected $client;


    /**
     * Get the initiating request object.
     *
     * @return AbstractRequest
     */
    public function getRequest()
    {
        return  $this->request;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        $message = null;
        $data = $this->data;
        if(is_array($data) && !empty($data['error'])){
            $message = $data['error'];
        }
        return $message;
    }

    /**
     * @return null|string
     */
    public function getCode()
    {
        $data = $this->data;
        if(is_array($data) && !empty($data['error']) && $data['code'] != 200){
            return $data['code'];
        }
        return null;
    }

    /**
     * @return null|Client
     */
    public function getClient()
    {
        return $this->getRequest()->getClient();
    }
}
