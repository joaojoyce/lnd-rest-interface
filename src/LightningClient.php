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


    public function getWalletBalance() {
        $client = new Client($this->http_config);

        $res = $client->request('GET', '/v1/balance/blockchain');
        return json_decode($res->getBody(),true);
    }

    public function getChannelBalance() {
        $client = new Client($this->http_config);

        $res = $client->request('GET', '/v1/balance/channels');
        return json_decode($res->getBody(),true);
    }

    public function getPendingChannels() {
        $client = new Client($this->http_config);

        $res = $client->request('GET', '/v1/channels/pending');
        return json_decode($res->getBody(),true);
    }

    public function getTransactions() {
        $client = new Client($this->http_config);

        $res = $client->request('GET', '/v1/transactions');
        return json_decode($res->getBody(),true);
    }

    public function getPeers() {
        $client = new Client($this->http_config);

        $res = $client->request('GET', '/v1/peers');
        return json_decode($res->getBody(),true);
    }

    public function getInvoices($pending_only = false) {

        if($pending_only) {
            $pending_only = 1;
        } else {
            $pending_only = 0;
        }

        $client = new Client($this->http_config);
        $res = $client->request('GET', '/v1/invoices/' . $pending_only);
        return json_decode($res->getBody(),true);
    }

    public function payinvoice($invoice) {
        $client = new Client($this->http_config);
        $res = $client->request('GET', '/v1/payreq/' . $invoice);
        return json_decode($res->getBody(),true);

    }

    public function sendpayment($destination,$payment_hash,$amount) {
        $client = new Client($this->http_config);
        $res = $client->request('POST', '/v1/channels/transactions',[
                'json' => [
                    'amt' => $amount,
                    'dest_string' => $destination,
                    'payment_hash_string' => $payment_hash
                ]
        ]);
        return json_decode($res->getBody(),true);

    }

    public function addinvoice($value,$memo='',$expiry=3600) {

        $client = new Client($this->http_config);
        $res = $client->request('POST', '/v1/invoices',[
            'json' => [
                'value' => $value,
                'memo'=> $memo,
                'expiry'=> $expiry
            ]
        ]);
        return json_decode($res->getBody(),true);

    }


}