<?php namespace JoaoJoyce\LndRestInterface;

use GuzzleHttp\Client;

class LightningClient
{

    protected $host;

    protected $port;

    protected $base_uri;

    protected $http_config;

    public function __construct($host,$port,$config = array())
    {
        $this->host = $host;
        $this->port = $port;
        $this->base_uri = 'https://' . $host . ':' . $port;
        $this->http_config = array_merge($config,array('base_uri' => $this->base_uri));
    }

    public function getInfo() {
        $client = new Client($this->http_config);

        $res = $client->request('GET', '/v1/getinfo');
        return json_decode($res->getBody(),true);

    }

}