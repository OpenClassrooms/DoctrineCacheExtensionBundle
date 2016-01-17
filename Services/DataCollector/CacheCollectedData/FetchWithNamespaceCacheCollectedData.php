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
     * @inheritdoc
     */
    public function __construct($id, $namespaceId = null, $data, $duration)
    {
        parent::__construct($id, $data, $duration);
        $this->namespaceId = $namespaceId;
    }

    /**
     * @return string
     */
    public function getNamespaceId()
    {
        return $this->namespaceId;
    }
}
