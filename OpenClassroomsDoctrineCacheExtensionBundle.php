<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\Compiler\DebugServiceCompilerPass;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\Compiler\ServiceCompilerPass;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\OpenClassroomsDoctrineCacheExtensionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsDoctrineCacheExtensionBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        if ($this->isDebug($container)) {
            $container->addCompilerPass(new DebugServiceCompilerPass());
        } else {
            $container->addCompilerPass(new ServiceCompilerPass());
        }
    }

    /**
     * @return bool
     */
    private function isDebug(ContainerBuilder $container)
    {
        return $container->hasParameter('kernel.debug') && $container->getParameter('kernel.debug');
    }

    public function getParent()
    {
        return 'DoctrineCacheBundle';
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new OpenClassroomsDoctrineCacheExtensionExtension();
    }
}
