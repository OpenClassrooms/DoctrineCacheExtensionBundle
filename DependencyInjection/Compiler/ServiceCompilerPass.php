<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ServiceCompilerPass implements CompilerPassInterface
{
    /**
     * @var string[]
     */
    public static $types =
        [
            'apc',
            'array',
            'couchbase',
            'file_system',
            'memcache',
            'memcached',
            'mongodb',
            'php_file',
            'redis',
            'riak',
            'wincache',
            'xcache',
            'zenddata',
        ];

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        foreach (self::$types as $type) {
            $definition = $container->findDefinition('doctrine_cache.abstract.'.$type);
            $definition->setFactory(
                array(
                    'OpenClassrooms\DoctrineCacheExtension\CacheProviderDecoratorFactory',
                    'create',
                )
            );
            $definition->addArgument($type);
        }
    }
}
