<?php

namespace App\Utils;

use Symfony\Component\HttpClient\HttpClient;

class OpenWeatherMapService
{
    private $url = "";
    private $apiKey = "";
    private $client;
    
    /**
     * @param array $config api connextion params: api url and token
     */
    public function __construct($config)
    {
        $this->url = $config["api_url"];
        $this->apiKey = $config["api_key"];
        $this->client = HttpClient::create();
    }

    public function getCurrentWeather($latitude, $longitude)
    {
        $currentWether = null;
        $url = $this->url."?lat=$latitude&lon=$longitude&exclude=hourly,daily,minutely,alerts&appid=$this->apiKey";

        $response = $this->client->request(
            'GET',
            $url
        );

        $statusCode = $response->getStatusCode();
        if($statusCode === 200)
        {
            $result = $response->toArray();
            if($result['current'])
            {
                $currentWether = $result['current'];
            }
        }
        return $currentWether;
    }
}