<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Services;

use Doctrine\Common\Cache\CacheProvider;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\CacheCollectedData\CacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\CacheCollectedData\FetchCacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\CacheCollectedData\FetchWithNamespaceCacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\CacheCollectedData\InvalidateCacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DebugCacheProviderDecorator;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DebugCacheProviderDecoratorFactory;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class DebugCacheProviderDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CacheProvider
     */
    private $cacheProvider;

    /**
     * @var DebugCacheProviderDecorator
     */
    private $decorator;

    /**
     * @test
     */
    public function FetchWithNamespace_StoreInformation()
    {
        $this->cacheProvider->save('namespaceId', 'namespace_id');
        $this->cacheProvider->save('namespace_idid', 'data-test');

        $this->decorator->fetchWithNamespace('id', 'namespaceId');
        $this->decorator->fetchWithNamespace('id', 'namespaceId');

        $this->assertCollectedData(
            [new FetchWithNamespaceCacheCollectedData('id', 'namespaceId', 'data-test', 0)],
            $this->decorator->getCollectedData()
        );
    }

    /**
     * @param CacheCollectedData[]|FetchCacheCollectedData[]|FetchWithNamespaceCacheCollectedData[] $expectedCollectedData
     * @param CacheCollectedData[]|FetchCacheCollectedData[]|FetchWithNamespaceCacheCollectedData[] $actualCollectedData
     */
    private function assertCollectedData(array $expectedCollectedData, array $actualCollectedData)
    {
        $i = 0;
        foreach ($expectedCollectedData as $expected) {
            $actual = $actualCollectedData[$i++];
            $this->assertEquals($expected->getData(), $actual->getData());
            $this->assertNotNull($actual->getDuration());
            $this->assertEquals($expected->getType(), $actual->getType());
            if ($expected instanceof FetchCacheCollectedData) {
                $this->assertEquals($expected->getId(), $actual->getId());
            }
            if ($expected instanceof FetchWithNamespaceCacheCollectedData || $expected instanceof InvalidateCacheCollectedData) {

                $this->assertEquals($expected->getNamespaceId(), $actual->getNamespaceId());
            }
        }
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $factory = new DebugCacheProviderDecoratorFactory();
        $factory->setStopwatch(new Stopwatch());
        $this->decorator = $factory->create('array');
        DebugCacheProviderDecorator::$callId = 0;
        DebugCacheProviderDecorator::$collectedData = [];

        $rp = new \ReflectionProperty($this->decorator, 'cacheProviderDecorator');
        $rp->setAccessible(true);
        $cacheProviderDecorator = $rp->getValue($this->decorator);

        $rp = new \ReflectionProperty($cacheProviderDecorator, 'cacheProvider');
        $rp->setAccessible(true);
        /** @var CacheProvider $cacheProvider */
        $this->cacheProvider = $rp->getValue($cacheProviderDecorator);
    }

}
