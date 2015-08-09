<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\OpenClassroomsDoctrineCacheExtensionBundle;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsDoctrineCacheExtensionBundleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getParent()
    {
        $bundle = new OpenClassroomsDoctrineCacheExtensionBundle();
        $this->assertEquals('DoctrineCacheBundle', $bundle->getParent());
    }
}
