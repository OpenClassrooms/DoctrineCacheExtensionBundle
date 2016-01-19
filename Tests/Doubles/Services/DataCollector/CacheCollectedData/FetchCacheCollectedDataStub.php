<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\FetchCacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FetchCacheCollectedDataStub extends FetchCacheCollectedData
{
    const ID = 'fetch id 1';

    const PROVIDER_ID = 'providerId';

    protected $id = self::ID;

    protected $providerId = self::PROVIDER_ID;

    public function __construct()
    {
    }
}
