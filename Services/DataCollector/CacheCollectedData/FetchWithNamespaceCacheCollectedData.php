<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FetchWithNamespaceCacheCollectedData extends FetchCacheCollectedData
{
    /**
     * @var string
     */
    protected $namespaceId;

    protected $type = self::FETCH_WITH_NAMESPACE;

    /**
     * @return string
     */
    public function getNamespaceId()
    {
        return $this->namespaceId;
    }

    public function setNamespaceId($namespaceId)
    {
        $this->namespaceId = $namespaceId;
    }
}
