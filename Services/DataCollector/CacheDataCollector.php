<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\CacheCollectedData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheDataCollector extends DataCollector
{
    const NAME = 'oc.doctrine_cache_extensions.services.data_collector.cache_data_collector';

    /**
     * @var CacheCollectedData[]
     */
    protected $data;

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = DebugCacheProviderDecorator::$collectedData;
    }

    /**
     * @return int
     */
    public function getAllQueriesCount()
    {
        return count($this->data);
    }

    /**
     * @return int
     */
    public function getAllQueriesDuration()
    {
        $time = 0;
        foreach ($this->data as $item) {
            $time += $item->getDuration();
        }

        return $time;
    }

    /**
     * @return int
     */
    public function getAllFetchQueriesCount()
    {
        return count($this->getQueriesByType([CacheCollectedData::FETCH, CacheCollectedData::FETCH_WITH_NAMESPACE]));
    }

    /**
     * @return CacheCollectedData[]
     */
    private function getQueriesByType(array $types)
    {
        $queries = [];
        foreach ($this->data as $item) {
            if (in_array($item->getType(), $types)) {
                $queries[] = $item;
            }
        }

        return $queries;
    }

    /**
     * @return int
     */
    public function getAllFetchQueriesDuration()
    {
        return $this->getQueriesDurationByType([CacheCollectedData::FETCH, CacheCollectedData::FETCH_WITH_NAMESPACE]);
    }

    /**
     * @return int
     */
    private function getQueriesDurationByType(array $types)
    {
        $duration = 0;
        foreach ($this->data as $item) {
            if (in_array($item->getType(), $types)) {
                $duration += $item->getDuration();
            }
        }

        return $duration;
    }

    /**
     * @return int
     */
    public function getAllSaveQueriesCount()
    {
        return count($this->getQueriesByType([CacheCollectedData::SAVE, CacheCollectedData::SAVE_WITH_NAMESPACE]));
    }

    /**
     * @return int
     */
    public function getAllSaveQueriesDuration()
    {
        return $this->getQueriesDurationByType([CacheCollectedData::SAVE, CacheCollectedData::SAVE_WITH_NAMESPACE]);
    }

    /**
     * @return array
     */
    public function getQueriesDetails()
    {
        $queriesDetails = [];
        foreach ($this->data as $callId => $item) {
            $queriesDetails[$item->getProviderId()][$callId] = $item;
        }
        ksort($queriesDetails);

        return $queriesDetails;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
