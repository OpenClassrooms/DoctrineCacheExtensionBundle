<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheDataCollector extends DataCollector
{
    /**
     * @inheritDoc
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = DebugCacheProviderDecorator::$collectedData;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'oc.services.data_collector.cache_data_collector';
    }

}
