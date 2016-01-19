<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class DebugServiceCompilerPass extends ServiceCompilerPass
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        parent::process($container);
        foreach ($container->getServiceIds() as $serviceId) {
            if (strpos($serviceId, 'doctrine_cache.providers.') === 0) {
                $definition = $container->findDefinition($serviceId);
                $definition->addMethodCall('setProviderId', [$serviceId]);
            }
        }
    }

    /**
     * @return string
     */
    protected function getFactoryService()
    {
        return 'oc.doctrine_cache_extensions.debug.cache_provider_decorator_factory';
    }
}
