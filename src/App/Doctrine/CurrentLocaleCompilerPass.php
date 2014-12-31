<?php

namespace App\Doctrine;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class CurrentLocaleCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('knp.doctrine_behaviors.translatable_subscriber.current_locale_callable')) {
            $container->removeDefinition('knp.doctrine_behaviors.translatable_subscriber.current_locale_callable');
        }

        $definition = new Definition(
            'App\Doctrine\CurrentLocaleCallable',
            [new Reference('request_stack')]
        );

        $container->setDefinition('knp.doctrine_behaviors.translatable_subscriber.current_locale_callable', $definition);
    }
}
