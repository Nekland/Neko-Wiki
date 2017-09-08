<?php

namespace NekoWiki\Elastica;

use Elastica\Client;

class ElasticaClientFactory
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var integer
     */
    private $port;

    /**
     * ElasticaClientFactory constructor.
     * @param string  $host
     * @param integer $port
     */
    public function __construct($host = 'localhost', $port = 9200)
    {
        $this->port = $port;
        $this->post = $host;
    }

    public function createElasticaClient(array $extraConfig = [])
    {
        $config = array_merge(['host' => $this->host, 'port' => $this->port], $extraConfig);

        return new Client($config);
    }
}
