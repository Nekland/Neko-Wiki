<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neko_wiki');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootChildren = $rootNode->children();

        $this->buildGlobalParametersConfig($rootChildren);

        $rootNode
            ->children()
            ->scalarNode('upload_dir')->defaultValue('uploads')->end()
            ->end();
        $rootChildren->end();

        return $treeBuilder;
    }

    /**
     * @param NodeBuilder $root
     */
    private function buildGlobalParametersConfig(NodeBuilder $root)
    {
        $root->arrayNode('general_parameters')
                ->children()
                    ->scalarNode('title')->defaultValue('Neko Wiki')->end()
                ->end()
        ->end();
    }
}
