<?php

namespace App\Search\ElasticSearch;


use App\Entity\PageTranslation;
use Elastica\Client;
use Elastica\Document;
use Elastica\Query;
use JMS\Serializer\Serializer;

class ElasticaTransformer
{
    private $index;
    private $client;
    private $serializer;

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
        $this->serializer = $serializer;
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
            // TODO: edit document
        } else {
            $document = new Document($entity->getId(), $this->serializer->serialize($entity, 'json'));
            $type->addDocument($document);
            $type->getIndex()->refresh();
        }
    }
}
