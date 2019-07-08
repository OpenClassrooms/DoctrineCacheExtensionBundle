<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\OpenClassroomsDoctrineCacheExtensionExtension;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\OpenClassroomsDoctrineCacheExtensionBundle;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsDoctrineCacheExtensionBundleTest extends TestCase
{
    /**
     * @test
     */
    public function getParent()
    {
        $bundle = new OpenClassroomsDoctrineCacheExtensionBundle();
        $this->assertInstanceOf(OpenClassroomsDoctrineCacheExtensionExtension::class, $bundle->getContainerExtension());
    }
}
