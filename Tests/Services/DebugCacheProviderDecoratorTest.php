<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Services;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\DebugCacheProviderDecorator;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\DebugCacheProviderDecoratorFactory;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\CacheCollectedDataTestCase;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\FetchCacheCollectedDataStub;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\FetchWithNamespaceCacheCollectedDataStub;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\InvalidateCacheCollectedDataStub;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\SaveCacheCollectedDataStub;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\SaveWithNamespaceCacheCollectedDataStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class DebugCacheProviderDecoratorTest extends \PHPUnit_Framework_TestCase
{
    use CacheCollectedDataTestCase;

    /**
     * @var DebugCacheProviderDecorator
     */
    private $decorator;

    /**
     * @test
     */
    public function fetch_storeInformation()
    {
        $this->decorator->fetch(FetchCacheCollectedDataStub::ID);
        $this->assertCacheCollectedData([new FetchCacheCollectedDataStub()], $this->decorator->getCollectedData());
    }

    /**
     * @test
     */
    public function fetchWithNamespace_storeInformation()
    {
        $this->decorator->fetchWithNamespace(
            FetchWithNamespaceCacheCollectedDataStub::ID,
            FetchWithNamespaceCacheCollectedDataStub::NAMESPACE_ID
        );
        $this->assertCacheCollectedData(
            [new FetchWithNamespaceCacheCollectedDataStub()],
            $this->decorator->getCollectedData()
        );
    }

    /**
     * @test
     */
    public function Invalidate_storeInformation()
    {
        $this->decorator->invalidate(InvalidateCacheCollectedDataStub::NAMESPACE_ID);
        $this->assertCacheCollectedData([new InvalidateCacheCollectedDataStub()], $this->decorator->getCollectedData());
    }

    /**
     * @test
     */
    public function Save_storeInformation()
    {
        $this->decorator->save(SaveCacheCollectedDataStub::ID, SaveCacheCollectedDataStub::DATA);
        $this->assertCacheCollectedData([new SaveCacheCollectedDataStub()], $this->decorator->getCollectedData());
    }

    /**
     * @test
     */
    public function SaveWithNamespace_storeInformation()
    {
        $this->decorator->saveWithNamespace(
            SaveWithNamespaceCacheCollectedDataStub::ID,
            SaveWithNamespaceCacheCollectedDataStub::DATA,
            SaveWithNamespaceCacheCollectedDataStub::NAMESPACE_ID
        );
        $this->assertCacheCollectedData(
            [new SaveWithNamespaceCacheCollectedDataStub()],
            $this->decorator->getCollectedData()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $factory = new DebugCacheProviderDecoratorFactory();
        $this->decorator = $factory->create('array');
        $this->decorator->setProviderId(FetchCacheCollectedDataStub::PROVIDER_ID);
        DebugCacheProviderDecorator::$callId = 0;
        DebugCacheProviderDecorator::$collectedData = [];
    }
}
