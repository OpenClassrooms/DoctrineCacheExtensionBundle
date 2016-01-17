<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('doctrine_cache_extension');
        $rootNode
            ->children()
                ->scalarNode('default_lifetime')->defaultValue(0)->end()
            ->end();

        return $treeBuilder;
    }
}
