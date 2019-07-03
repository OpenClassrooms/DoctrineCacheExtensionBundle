<?php

namespace Services\DataCollector\CacheCollectedData;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\CacheCollectedDataBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheCollectedDataBuilderTest extends TestCase
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
