<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class NekoWikiExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->setupParameterProvider($container, $config);

        $definition = $container->getDefinition('neko_wiki.language.manager');
        $definition->addArgument($config['general_parameters']['languages']);

        $this->loadSearchConfig($config, $container);
        $this->loadElasticSearchConfig($config, $container);
    }

    public function loadSearchConfig(array $config, ContainerBuilder $container)
    {
        switch($config['general_parameters']['search_strategy']) {
            case 'repository':
                // This is the default configuration
                break;
            case 'elastic_search':
                $searchDefinition = $container->getDefinition('neko_wiki.searcher');
                $searchDefinition->setClass('App\Search\ElasticSearch');
                break;
            default:
                throw new InvalidConfigurationException;
        }
    }

    /**
     * Add the parameters given in conf to ES services that need them.
     *
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadElasticSearchConfig(array $config, ContainerBuilder $container)
    {
        $definition = $container->getDefinition('neko_wiki.elastic.client_factory');
        $definition->addArgument($config['elasticsearch']['host'])->addArgument($config['elasticsearch']['port']);


        if ($config['elasticsearch']['index'] === 'neko_wiki') {
            $index = 'neko_wiki_' . $container->getParameter("kernel.environment");
        } else {
            $index = $config['elasticsearch']['index'];
        }
        $container->setParameter('neko_wiki.elasticsearch.page_index', $index);
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     */
    private function setupParameterProvider(ContainerBuilder $container, $config)
    {
        $definition = $container->getDefinition('neko_wiki.provider.wiki_parameter');
        $definition->addArgument($config['general_parameters']);
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'neko_wiki';
    }
}
