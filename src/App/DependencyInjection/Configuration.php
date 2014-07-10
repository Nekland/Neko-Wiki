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

        $rootChildren = $rootNode->children();

        $this->buildGlobalParametersConfig($rootChildren);

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
