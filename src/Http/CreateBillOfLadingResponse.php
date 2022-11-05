<?php

namespace Omniship\Glovo\Http;

use Carbon\Carbon;
use Omniship\Common\Bill\Create;
use Omniship\Glovo\Client;

class CreateBillOfLadingResponse extends AbstractResponse
{
    /**
     * @var Parcel
     */
    protected $data;
    /**
     * @return Create
     */
    public function getData()
    {
        if(!empty($this->getMessage())){
            return null;
        }

        $data = $this->data;
        $result = new Create();
        $result->setBolId($data->id.' - '.$data->code);
        return $result;
    }

}
