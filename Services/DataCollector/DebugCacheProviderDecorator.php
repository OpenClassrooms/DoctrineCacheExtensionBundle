<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\CacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\CacheCollectedDataBuilder;
use OpenClassrooms\DoctrineCacheExtension\AbstractCacheProviderDecorator;
use OpenClassrooms\DoctrineCacheExtension\CacheProviderDecorator;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class DebugCacheProviderDecorator extends CacheProviderDecorator
{
    const STOPWATCH_EVENT = 'doctrine_cache_extension_bundle';

    /**
     * @var CacheCollectedData[]
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
     * @var CacheCollectedDataBuilder
     */
    private $cacheCollectedDataBuilder;

    /**
     * @var AbstractCacheProviderDecorator
     */
    private $cacheProviderDecorator;

    /**
     * @var string
     */
    private $providerId;

    public function __construct(AbstractCacheProviderDecorator $cacheProviderDecorator, Stopwatch $stopwatch)
    {
        parent::__construct($cacheProviderDecorator->getCacheProvider(), $cacheProviderDecorator->getDefaultLifetime());
        $this->cacheProviderDecorator = $cacheProviderDecorator;
        $this->cacheCollectedDataBuilder = new CacheCollectedDataBuilder();
        self::$stopwatch = $stopwatch;
    }

    /**
     * @return CacheCollectedData[]
     */
    public static function getCollectedData()
    {
        return self::$collectedData;
    }

    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($id)
    {
        $start = $this->startQuery();
        $data = $this->cacheProviderDecorator->fetch($id);
        $stop = $this->stopQuery();

        self::$collectedData[self::$callId++] = $this->create(CacheCollectedData::FETCH)
            ->withData($data)
            ->withId($id)
            ->withStart($start)
            ->withStop($stop)
            ->build();

        return $data;
    }

    /**
     * @return float
     */
    private function startQuery()
    {
        self::$stopwatch->start('oc.doctrine_cache_extension_bundle', 'oc.doctrine_cache_extension_bundle');

        return microtime(true);
    }

    /**
     * @return float
     */
    private function stopQuery()
    {
        self::$stopwatch->stop('oc.doctrine_cache_extension_bundle');

        return microtime(true);
    }

    /**
     * @return CacheCollectedDataBuilder
     */
    private function create($type)
    {
        return $this->cacheCollectedDataBuilder
            ->create($type)
            ->withProviderId($this->providerId);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchWithNamespace($id, $namespaceId = null)
    {
        $start = $this->startQuery();
        $data = $this->cacheProviderDecorator->fetchWithNamespace($id, $namespaceId);
        $stop = $this->stopQuery();

        self::$collectedData[self::$callId++] = $this->create(CacheCollectedData::FETCH_WITH_NAMESPACE)
            ->withData($data)
            ->withId($id)
            ->withNamespaceId($namespaceId)
            ->withStart($start)
            ->withStop($stop)
            ->build();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function invalidate($namespaceId)
    {
        $start = $this->startQuery();
        $invalidated = $this->cacheProviderDecorator->invalidate($namespaceId);
        $stop = $this->stopQuery();

        self::$collectedData[self::$callId++] = $this->create(CacheCollectedData::INVALIDATE)
            ->withNamespaceId($namespaceId)
            ->withStart($start)
            ->withStop($stop)
            ->build();

        return $invalidated;
    }

    /**
     * {@inheritdoc}
     */
    public function save($id, $data, $lifeTime = null)
    {
        $start = $this->startQuery();
        $saved = $this->cacheProviderDecorator->save($id, $data, $lifeTime);
        $stop = $this->stopQuery();

        self::$collectedData[self::$callId++] = $this->create(CacheCollectedData::SAVE)
            ->withData($data)
            ->withId($id)
            ->withStart($start)
            ->withStop($stop)
            ->build();

        return $saved;
    }

    /**
     * {@inheritdoc}
     */
    public function saveWithNamespace($id, $data, $namespaceId = null, $lifeTime = null)
    {
        $start = $this->startQuery();
        $saved = $this->cacheProviderDecorator->saveWithNamespace($id, $data, $namespaceId, $lifeTime);
        $stop = $this->stopQuery();

        self::$collectedData[self::$callId++] = $this->create(CacheCollectedData::SAVE_WITH_NAMESPACE)
            ->withData($data)
            ->withId($id)
            ->withNamespaceId($namespaceId)
            ->withStart($start)
            ->withStop($stop)
            ->build();

        return $saved;
    }
}
