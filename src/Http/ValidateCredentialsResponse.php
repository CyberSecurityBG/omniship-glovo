<?php

namespace Omniship\Glovo\Http;

class ValidateCredentialsResponse extends AbstractResponse
{

    /**
     * @return bool
     */
    public function getData()
    {
        if($this->data){
            return true;
        }
        return false;
    }

}
