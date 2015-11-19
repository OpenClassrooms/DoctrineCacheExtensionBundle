<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle;

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
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ServiceCompilerPass());
    }

    public function getParent()
    {
        return 'DoctrineCacheBundle';
    }

    /**
     * @inheritDoc
     */
    public function getContainerExtension()
    {
        return new OpenClassroomsDoctrineCacheExtensionExtension();
}

}
