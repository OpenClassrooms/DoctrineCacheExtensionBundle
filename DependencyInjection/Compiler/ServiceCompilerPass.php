<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

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
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $factoryService = $this->getFactoryService();
        foreach (self::$types as $type) {
            $definition = $container->findDefinition('doctrine_cache.abstract.'.$type);
            $definition->setFactory([new Reference($factoryService), 'create']);
            $definition->addArgument($type);
        }
    }

    /**
     * @return string
     */
    protected function getFactoryService()
    {
        return 'oc.doctrine_cache_extensions.cache_provider_decorator_factory';
    }
}
