<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsDoctrineCacheExtensionExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $config);
        $container->setParameter('doctrine_cache_extension.default_lifetime', $config['default_lifetime']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/'));
        $loader->load('services.xml');
        if ($this->isDebug($container)) {
            $loader->load('services_debug.xml');
        }
    }

    /**
     * @return bool
     */
    private function isDebug(ContainerBuilder $container)
    {
        return $container->hasParameter('kernel.debug') && $container->getParameter('kernel.debug');
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'doctrine_cache_extension';
    }
}
