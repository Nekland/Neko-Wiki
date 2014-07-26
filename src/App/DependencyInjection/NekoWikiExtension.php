<?php

namespace App\DependencyInjection;



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
