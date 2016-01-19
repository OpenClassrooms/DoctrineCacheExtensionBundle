<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class CacheCollectedData
{
    const INVALIDATE = 'invalidate';

    const FETCH = 'fetch';

    const FETCH_WITH_NAMESPACE = 'fetchWithNamespace';

    const SAVE = 'save';

    const SAVE_WITH_NAMESPACE = 'saveWithNamespace';

    /**
     * @var string
     */
    protected $data;

    /**
     * @var string
     */
    protected $providerId;

    /**
     * @var float
     */
    protected $start;

    /**
     * @var float
     */
    protected $stop;

    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return float
     */
    public function getDuration()
    {
        return $this->stop - $this->start;
    }

    /**
     * @return string
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function setStop($stop)
    {
        $this->stop = $stop;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
