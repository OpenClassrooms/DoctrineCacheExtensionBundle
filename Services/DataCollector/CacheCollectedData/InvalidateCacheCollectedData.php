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

    public function __construct($namespaceId, $data, $duration)
    {
        parent::__construct($data, $duration);
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
