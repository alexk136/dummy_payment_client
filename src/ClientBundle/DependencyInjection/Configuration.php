<?php

declare(strict_types=1);

namespace DummyDemo\ClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('dummy_demo_client');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->integerNode('partner_id')->defaultValue(0)->end()
                ->scalarNode('password')->defaultValue('')->end()
                ->scalarNode('username')->defaultValue('')->end()
                ->scalarNode('uid')->defaultValue('')->end()
                ->scalarNode('host')->defaultValue('')->end()
                ->scalarNode('sign_callback')->defaultNull()->end()
                ->scalarNode('sign_validator_callback')->defaultNull()->end()
                ->scalarNode('http_client_service')->defaultNull()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
