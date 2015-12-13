<?php

namespace App\Search\ElasticSearch;


use App\Entity\PageTranslation;
use Elastica\Client;
use Elastica\Query;
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

        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->index);
        $search->addType($type);

        $search->setQuery(new Query(new Query\Match('id', $entity->getId())));

        $result = $search->search();
        if ($result->count() > 0) {
            // edit only
        } else {
            // add new
        }

        // TODO: add entity in elasticsearch OR update it
    }
}
