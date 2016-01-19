<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\FetchWithNamespaceCacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FetchWithNamespaceCacheCollectedDataStub extends FetchWithNamespaceCacheCollectedData
{
    const ID = 'fetch id 1';

    const NAMESPACE_ID = 'fetch namespaceId 1';

    const PROVIDER_ID = 'providerId';

    protected $id = self::ID;

    protected $namespaceId = self::NAMESPACE_ID;

    protected $providerId = self::PROVIDER_ID;

    public function __construct()
    {
    }
}
