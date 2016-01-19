<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\SaveWithNamespaceCacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SaveWithNamespaceCacheCollectedDataStub extends SaveWithNamespaceCacheCollectedData
{
    const DATA = 'save cache data';

    const ID = 'save id 1';

    const NAMESPACE_ID = 'save namespaceId 1';

    const PROVIDER_ID = 'providerId';

    protected $id = self::ID;

    protected $data = self::DATA;

    protected $namespaceId = self::NAMESPACE_ID;

    protected $providerId = self::PROVIDER_ID;

    public function __construct()
    {
    }
}
