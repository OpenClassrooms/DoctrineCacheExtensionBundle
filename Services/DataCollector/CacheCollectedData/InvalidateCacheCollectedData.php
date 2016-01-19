<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class InvalidateCacheCollectedData extends CacheCollectedData
{
    /**
     * @var string
     */
    protected $namespaceId;

    protected $type = self::INVALIDATE;

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
