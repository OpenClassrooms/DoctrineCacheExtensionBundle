<?php

namespace Services\DataCollector\CacheCollectedData;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\CacheCollectedDataBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheCollectedDataBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function InvalidType_ThrowException()
    {
        $cacheCollectedDataBuilder = new CacheCollectedDataBuilder();
        $cacheCollectedDataBuilder->create('invalid');
    }
}
