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
        $factoryClass = $this->getFactoryClass($container);
        foreach (self::$types as $type) {
            $definition = $container->findDefinition('doctrine_cache.abstract.'.$type);
            $definition->setFactory([$factoryClass, 'create']);
            $definition->addArgument($type);
        }

        if ($this->isDebug($container)) {

            foreach ($container->getServiceIds() as $serviceId) {
                if (strpos($serviceId, 'doctrine_cache.providers.') === 0) {
                    $definition = $container->findDefinition($serviceId);
                    $definition->addMethodCall('setProviderId', [$serviceId]);
                }
            }
        }
    }

    /**
     * @return string
     */
    private function getFactoryClass(ContainerBuilder $container)
    {
        if ($this->isDebug($container)) {
            return $container->findDefinition('oc.doctrine_cache_extensions.debug.cache_provider_decorator_factory')
                ->getClass();
        } else {
            return $container->findDefinition('oc.doctrine_cache_extensions.cache_provider_decorator_factory')
                ->getClass();
        }
    }

    /**
     * @return bool
     */
    private function isDebug(ContainerBuilder $container)
    {
        return $container->hasParameter('kernel.debug') && $container->getParameter('kernel.debug');
    }
}
