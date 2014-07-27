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
            ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('title')->defaultValue('Neko Wiki')->end()
                    ->arrayNode('languages')
                        ->defaultValue(['en'])
                        ->validate()
                        ->ifTrue(function($languages) { foreach($languages as $lang) { if(!preg_match('/^[a-z]{2}$/', $lang)) return true;  } return false; })
                            ->thenInvalid('The format of languages in configuration is 2 characters.')
                        ->end()
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
        ->end();
    }
}
