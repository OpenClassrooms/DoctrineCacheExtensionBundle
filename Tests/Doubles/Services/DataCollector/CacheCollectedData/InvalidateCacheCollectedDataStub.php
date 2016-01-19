<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\InvalidateCacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class InvalidateCacheCollectedDataStub extends InvalidateCacheCollectedData
{
    const NAMESPACE_ID = 'invalidate namespaceId 1';

    const PROVIDER_ID = 'providerId';

    protected $namespaceId = self::NAMESPACE_ID;

    protected $providerId = self::PROVIDER_ID;

    public function __construct()
    {
    }
}
