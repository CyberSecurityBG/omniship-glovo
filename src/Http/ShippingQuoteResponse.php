<?php

namespace Omniship\Glovo\Http;
use Omniship\Common\ShippingQuoteBag;

/**
 * Class ShippingQuoteResponse
 */
class ShippingQuoteResponse extends AbstractResponse
{
    public function getData()
    {
        if(!empty($this->getMessage())){
             return null;
        }
        $result = new ShippingQuoteBag();
        $result->push( [
            'id' => 1,
            'name' => 'Standart',
            'description' => null,
            'price' => number_format($this->data->total->amount/100, 2, '.', ''),
            'pickup_date' => null,
            'pickup_time' => null,
            'delivery_date' => null,
            'delivery_time' => null,
            'currency' => $this->data->total->currency,
            'tax' => null,
            'insurance' => null,
            'exchange_rate' => null,
          //  'payer' => $this->getRequest()->getPayer(),
            'allowance_fixed_time_delivery' => false,
            'allowance_cash_on_delivery' => true,
            'allowance_insurance' => true,
        ]);
        return $result;
    }
}
