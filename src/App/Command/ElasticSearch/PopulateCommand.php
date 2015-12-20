<?php

namespace App\Command\ElasticSearch;


use Elastica\Document;
use Elastica\Query\MatchAll;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('neko-wiki:elasticsearch:populate')
            ->setDescription('Add searchable content to elasticsearch.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repo = $this->getContainer()->get('doctrine')->getManager()->getRepository('NekoWiki:PageTranslation');
        $translations = $repo->findAll();

        $client = $this->getContainer()->get('neko_wiki.elastica.client');
        $serializer = $this->getContainer()->get('serializer');

        $index = $client->getIndex($this->getContainer()->getParameter('neko_wiki.elasticsearch.page_index'));
        $type = $index->getType('page');

        $type->deleteByQuery(new MatchAll());
        $type->getIndex()->refresh();

        $nbOfTranslations = count($translations);
        $progress = new ProgressBar($output, $nbOfTranslations);
        //$progress->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');


        foreach ($translations as $translation) {
            $document = new Document($translation->getId(), $serializer->serialize($translation, 'json'));
            $type->addDocument($document);
            $progress->advance();
        }
        $type->getIndex()->refresh();
        $progress->finish();

        $output->writeln(sprintf("\n<info>%s pages inserted with success in elasticsearch.</info>", $nbOfTranslations));
    }

}
