<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\CacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\FetchWithNamespaceCacheCollectedData;
use OpenClassrooms\DoctrineCacheExtension\AbstractCacheProviderDecorator;
use OpenClassrooms\DoctrineCacheExtension\CacheProviderDecorator;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class DebugCacheProviderDecorator extends CacheProviderDecorator
{
    /**
     * @var array
     */
    public static $collectedData = [];

    /**
     * @var int
     */
    public static $callId = 0;

    /**
     * @var Stopwatch
     */
    public static $stopwatch;

    /**
     * @var AbstractCacheProviderDecorator
     */
    private $cacheProviderDecorator;

    public function __construct(AbstractCacheProviderDecorator $cacheProviderDecorator, Stopwatch $stopwatch)
    {
        $this->cacheProviderDecorator = $cacheProviderDecorator;
        self::$stopwatch = $stopwatch;
    }

    /**
     * @return CacheCollectedData[]
     */
    public static function getCollectedData()
    {
        return self::$collectedData;
    }

    /**
     * @inheritDoc
     */
    public function fetchWithNamespace($id, $namespaceId = null)
    {
        self::$stopwatch->start('doctrine_cache_extension_bundle');
        $data = $this->cacheProviderDecorator->fetchWithNamespace($id, $namespaceId);
        self::$stopwatch->stop('doctrine_cache_extension_bundle');

        self::$collectedData[self::$callId++] = new FetchWithNamespaceCacheCollectedData(
            $id,
            $namespaceId,
            $data,
            self::$stopwatch
        );

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function invalidate($namespaceId)
    {
        return $this->cacheProviderDecorator->invalidate($namespaceId);
    }

    /**
     * @inheritDoc
     */
    public function save($id, $data, $lifeTime = null)
    {
        return $this->cacheProviderDecorator->save($id, $data, $lifeTime);
    }

    /**
     * @inheritDoc
     */
    public function saveWithNamespace($id, $data, $namespaceId = null, $lifeTime = null)
    {
        return $this->cacheProviderDecorator->saveWithNamespace($id, $data, $namespaceId, $lifeTime);
    }

    /**
     * @inheritDoc
     */
    protected function doFetch($id)
    {
        return $this->cacheProviderDecorator->doFetch($id);
    }

    /**
     * @inheritDoc
     */
    protected function doContains($id)
    {
        return $this->cacheProviderDecorator->doContains($id);
    }

    /**
     * @inheritDoc
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        return $this->cacheProviderDecorator->doSave($id, $data, $lifeTime);
    }

    /**
     * @inheritDoc
     */
    protected function doDelete($id)
    {
        return $this->cacheProviderDecorator->doDelete($id);
    }

    /**
     * @inheritDoc
     */
    protected function doFlush()
    {
        return $this->cacheProviderDecorator->doFlush();
    }

    /**
     * @inheritDoc
     */
    protected function doGetStats()
    {
        return $this->cacheProviderDecorator->doGetStats();
    }
}
