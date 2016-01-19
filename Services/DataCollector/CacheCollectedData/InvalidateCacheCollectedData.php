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

    public function setNamespaceId(string $namespaceId)
    {
        $this->namespaceId = $namespaceId;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}
