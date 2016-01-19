<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheCollectedDataBuilder
{
    /**
     * @var CacheCollectedData|FetchCacheCollectedData|FetchWithNamespaceCacheCollectedData|InvalidateCacheCollectedData|SaveCacheCollectedData|SaveWithNamespaceCacheCollectedData
     */
    private $cacheCollectedData;

    /**
     * @return CacheCollectedDataBuilder
     */
    public function create($type)
    {
        switch ($type) {
            case CacheCollectedData::FETCH :
                $this->cacheCollectedData = new FetchCacheCollectedData();
                break;
            case CacheCollectedData::FETCH_WITH_NAMESPACE:
                $this->cacheCollectedData = new FetchWithNamespaceCacheCollectedData();
                break;
            case CacheCollectedData::INVALIDATE:
                $this->cacheCollectedData = new InvalidateCacheCollectedData();
                break;
            case CacheCollectedData::SAVE:
                $this->cacheCollectedData = new SaveCacheCollectedData();
                break;
            case CacheCollectedData::SAVE_WITH_NAMESPACE:
                $this->cacheCollectedData = new SaveWithNamespaceCacheCollectedData();
                break;
            default:
                throw new \InvalidArgumentException($type);
        }

        return $this;
    }

    /**
     * @return CacheCollectedDataBuilder
     */
    public function withData($data)
    {
        $this->cacheCollectedData->setData($data);

        return $this;
    }

    /**
     * @return CacheCollectedDataBuilder
     */
    public function withId($id)
    {
        $this->cacheCollectedData->setId($id);

        return $this;
    }

    /**
     * @return CacheCollectedDataBuilder
     */
    public function withNamespaceId($namespaceId)
    {
        $this->cacheCollectedData->setNamespaceId($namespaceId);

        return $this;
    }

    /**
     * @return CacheCollectedDataBuilder
     */
    public function withProviderId($providerId)
    {
        $this->cacheCollectedData->setProviderId($providerId);

        return $this;
    }

    /**
     * @return CacheCollectedDataBuilder
     */
    public function withStart($start)
    {
        $this->cacheCollectedData->setStart($start);

        return $this;
    }

    /**
     * @return CacheCollectedDataBuilder
     */
    public function withStop($stop)
    {
        $this->cacheCollectedData->setStop($stop);

        return $this;
    }

    /**
     * @return CacheCollectedDataBuilder
     */
    public function build()
    {
        return $this->cacheCollectedData;
    }
}
