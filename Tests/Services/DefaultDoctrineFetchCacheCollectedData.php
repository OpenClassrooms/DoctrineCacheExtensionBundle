<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Services;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\FetchCacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class DefaultDoctrineFetchCacheCollectedData extends FetchCacheCollectedData
{
    public $id = 'DoctrineNamespaceCacheKey[]';

    public $data = false;

    public function __construct()
    {

    }
}
