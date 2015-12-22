<?php

namespace App\Search\ElasticSearch;


use App\Entity\PageTranslation;
use Doctrine\ORM\EntityManager;
use Elastica\Client;
use Elastica\Document;
use Elastica\Query;
use JMS\Serializer\Serializer;

class ElasticaTransformer
{
    private $index;
    private $client;
    private $serializer;
    private $entityManager;

    /**
     * ElasticaTransformer constructor.
     * @param string     $index
     * @param Client     $elasticaClient
     * @param Serializer $serializer
     */
    public function __construct($index, Client $elasticaClient, Serializer $serializer, EntityManager $entityManager)
    {
        $this->client = $elasticaClient;
        $this->index = $elasticaClient->getIndex($index);
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    public function get($query, $entity='NekoWiki:PageTranslation')
    {
        if (!$entity instanceof PageTranslation) {
            throw new \Exception(sprintf('Entity %s currently not supported in elasticsearch persist.', $entity));
        }


        $type = $this->index->getType('page');

        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->index);
        $search->addType($type);

        $search->setQuery($query);

        $results = $search->search();
        if ($results->count() === 0) {
            return [];
        }

        $ids = [];

        foreach ($results as $result) {
            $ids[] = $result->getId();
        }

        $items = $this->entityManager->getRepository('NekoWiki:PageTranslation')->findByIds($ids);

        $idPos = array_flip($ids);
        usort($items, function ($a, $b) use ($idPos) {
            return $idPos[$a->getId()] > $idPos[$b->getId()];
        });

        // Idea : we could add a new interface HighlightableModelInterface
        // they do it in FOSElasticaBundle

        return $items;
    }

    public function save($entity)
    {
        if (!$entity instanceof PageTranslation) {
            throw new \Exception(sprintf('Entity %s currently not supported in elasticsearch persist.', get_class($entity)));
        }

        $type = $this->index->getType('page');

        $search = new \Elastica\Search($this->client);
        $search->addIndex($this->index);
        $search->addType($type);

        $search->setQuery(new Query(new Query\Match('id', $entity->getId())));

        $result = $search->search();
        if ($result->count() > 0) {
            $this->delete($entity);
        }

        $document = new Document($entity->getId(), $this->serializer->serialize($entity, 'json'));
        $type->addDocument($document);
        $type->getIndex()->refresh();

    }

    public function delete($entity)
    {
        if (!$entity instanceof PageTranslation) {
            throw new \Exception(sprintf('Entity %s currently not supported in elasticsearch persist.', get_class($entity)));
        }

        $type = $this->index->getType('page');
        $type->deleteDocument($entity->getId());
        $type->getIndex()->refresh();
    }
}
