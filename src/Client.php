<?php

namespace Omniship\Glovo;

use Carbon\Carbon;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use http\Client\Response;

class Client
{

    protected $public_key;
    protected $private_key;
    protected $error;
    const SERVICE_PRODUCTION_URL = 'https://api.glovoapp.com/';
    const TEST_URL = 'https://stageapi.glovoapp.com/';

    public function __construct($public_key, $private_key)
    {
        $this->public_key = $public_key;
        $this->private_key = $private_key;
    }


    public function getError()
    {
        return $this->error;
    }


    /**
     * @param $method
     * @param $endpoint
     * @param $data
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function SendRequest($method, $endpoint, $data = [])
    {
        try {
            $client = new HttpClient(['base_uri' => self::TEST_URL]);
            if($method == 'GET'){
                $response = $client->get($endpoint, [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Basic '.base64_encode($this->public_key.':'.$this->private_key),
                    ],
                    'debug' => fopen('php://stderr', 'w'),
                ]);
            }
            if($method == 'POST'){
                $response = $client->post($endpoint, [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Basic '.base64_encode($this->public_key.':'.$this->private_key),
                    ],
                    'debug' => fopen('php://stderr', 'w'),
                    'json' => $data
                ]);
            }

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return $this->error = [
                'code' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }

    }
}
