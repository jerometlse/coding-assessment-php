<?php

namespace App\Utils;
use Symfony\Component\HttpClient\HttpClient;



class MapboxService{

    private $url = "";
    private $token = "";
    private $client;
    
    /**
     * @param array $config api connextion params: api url and token
     */
    public function __construct($config)
    {
        $this->url = $config["api_url"];
        $this->token = $config["token"];
        $this->client = HttpClient::create();
    }

    /**
     * @param string $address searched address 
     */
    public function getAddressLatitudeAndLongitude(string $address): array
    {
        $coordinates = [ 
            'longitude'=> null,
            'latitude'=> null,
        ];

        $url = $this->url ."/mapbox.places/$address.json?access_token=".$this->token;
        $response = $this->client->request(
            'GET',
            $url
        );

        $statusCode = $response->getStatusCode();
        $result = $response->toArray();
        if($statusCode === 200 and $result['features'] and count($result['features'])){
            $firstfeature = $result['features'][0];
            $coordinates['longitude'] = $firstfeature['center'][0];
            $coordinates['latitude'] = $firstfeature['center'][1];
        }
        
        return $coordinates;
    }
}