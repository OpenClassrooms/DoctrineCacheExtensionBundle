<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData;

use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class CacheCollectedData
{
    const INVALIDATE = 'invalidate';

    const FETCH = 'fetch';

    const FETCH_WITH_NAMESPACE = 'fetchWithNamespace';

    /**
     * @var string
     */
    protected $data;

    /**
     * @var Stopwatch
     */
    protected $duration;

    /**
     * @var string
     */
    protected $type;

    public function __construct($data, $duration)
    {
        $this->data = $data;
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
