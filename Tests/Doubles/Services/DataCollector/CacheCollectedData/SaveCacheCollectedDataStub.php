<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\SaveCacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SaveCacheCollectedDataStub extends SaveCacheCollectedData
{
    const DATA = 'save cache data';

    const ID = 'save id 1';

    const PROVIDER_ID = 'providerId';

    protected $data = self::DATA;

    protected $id = self::ID;

    protected $providerId = self::PROVIDER_ID;

    public function __construct()
    {
    }
}
