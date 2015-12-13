<?php

namespace App\Search\ElasticSearch;


use App\Entity\PageTranslation;
use Elastica\Client;
use JMS\Serializer\Serializer;

class ElasticaTransformer
{
    private $index;
    private $client;

    /**
     * ElasticaTransformer constructor.
     * @param string     $index
     * @param Client     $elasticaClient
     * @param Serializer $serializer
     */
    public function __construct($index, Client $elasticaClient, Serializer $serializer)
    {
        $this->client = $elasticaClient;
        $this->index = $elasticaClient->getIndex($index);
    }

    public function get($query)
    {

    }

    public function save($entity)
    {
        if (!$entity instanceof PageTranslation) {
            throw new \Exception(sprintf('Class %s currently not supported in elasticsearch persist.', get_class($entity)));
        }

        $type = $this->index->getType('page');

        // TODO: check if the entity already exists in elasticsearch
        // TODO: add entity in elasticsearch OR update it
    }
}
