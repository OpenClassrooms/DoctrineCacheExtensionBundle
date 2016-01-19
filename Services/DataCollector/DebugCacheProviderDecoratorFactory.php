<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector;

use OpenClassrooms\DoctrineCacheExtension\CacheProviderDecoratorFactory;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class DebugCacheProviderDecoratorFactory extends CacheProviderDecoratorFactory
{
    /**
     * @var Stopwatch
     */
    private static $stopwatch;

    /**
     * @inheritdoc
     */
    public static function create($type, ...$args)
    {
        if (null === self::$stopwatch) {
            self::$stopwatch = new Stopwatch();
        }

        return new DebugCacheProviderDecorator(parent::create($type, ...$args), self::$stopwatch);
    }

    public static function setStopwatch(Stopwatch $stopwatch)
    {
        self::$stopwatch = $stopwatch;
    }
}
