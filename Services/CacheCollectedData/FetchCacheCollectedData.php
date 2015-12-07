<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\CacheCollectedData;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FetchCacheCollectedData extends CacheCollectedData
{
    /**
     * @var string
     */
    protected $id;

    protected $type = self::FETCH;

    /**
     * @inheritdoc
     */
    public function __construct($id, $data, $duration)
    {
        parent::__construct($data, $duration);
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
