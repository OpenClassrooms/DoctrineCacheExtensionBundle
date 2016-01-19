<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\CacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\FetchCacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\FetchWithNamespaceCacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\InvalidateCacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\SaveCacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\SaveWithNamespaceCacheCollectedData;
use PHPUnit_Framework_Assert as Assert;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
trait CacheCollectedDataTestCase
{
    /**
     * @param CacheCollectedData[] $expectedCollectedData
     * @param CacheCollectedData[] $actualCollectedData
     */
    protected function assertCacheCollectedData(array $expectedCollectedData, array $actualCollectedData)
    {
        Assert::assertCount(count($expectedCollectedData), $actualCollectedData);
        foreach ($expectedCollectedData as $key => $expectedItem) {
            $this->assertSingleCacheCollectedData($expectedItem, $actualCollectedData[$key]);
        }
    }

    /**
     * @param FetchCacheCollectedData|FetchWithNamespaceCacheCollectedData|InvalidateCacheCollectedData|SaveCacheCollectedData|SaveWithNamespaceCacheCollectedData $expected
     * @param FetchCacheCollectedData|FetchWithNamespaceCacheCollectedData|InvalidateCacheCollectedData|SaveCacheCollectedData|SaveWithNamespaceCacheCollectedData $actual
     */
    protected function assertSingleCacheCollectedData(CacheCollectedData $expected, CacheCollectedData $actual)
    {
        $this->assertCommonCacheCollectedData($expected, $actual);
        if ($expected instanceof FetchCacheCollectedData) {
            $this->assertFetchCacheCollectedData($expected, $actual);
        }
        if ($expected instanceof FetchWithNamespaceCacheCollectedData) {
            $this->assertFetchWithNamespaceCacheCollectedData($expected, $actual);
        }
        if ($expected instanceof InvalidateCacheCollectedData) {
            $this->assertInvalidateCacheCollectedData($expected, $actual);
        }
        if ($expected instanceof SaveCacheCollectedData) {
            $this->assertSaveCacheCollectedData($expected, $actual);
        }
        if ($expected instanceof SaveWithNamespaceCacheCollectedData) {
            $this->assertSaveWithNamespaceCacheCollectedData($expected, $actual);
        }
    }

    protected function assertCommonCacheCollectedData(CacheCollectedData $expected, CacheCollectedData $actual)
    {
        Assert::assertEquals($expected->getData(), $actual->getData());
        Assert::assertNotNull($actual->getDuration());
        Assert::assertEquals($expected->getProviderId(), $actual->getProviderId());
        Assert::assertEquals($expected->getType(), $actual->getType());
    }

    private function assertFetchCacheCollectedData(FetchCacheCollectedData $expected, FetchCacheCollectedData $actual)
    {
        Assert::assertEquals($expected->getId(), $actual->getId());
    }

    private function assertFetchWithNamespaceCacheCollectedData(
        FetchWithNamespaceCacheCollectedData $expected,
        FetchWithNamespaceCacheCollectedData $actual
    ) {
        $this->assertFetchCacheCollectedData($expected, $actual);
        Assert::assertEquals($expected->getNamespaceId(), $actual->getNamespaceId());
    }

    private function assertInvalidateCacheCollectedData(
        InvalidateCacheCollectedData $expected,
        InvalidateCacheCollectedData $actual
    ) {
        Assert::assertEquals($expected->getNamespaceId(), $actual->getNamespaceId());
    }

    private function assertSaveCacheCollectedData(SaveCacheCollectedData $expected, SaveCacheCollectedData $actual)
    {
        Assert::assertEquals($expected->getId(), $actual->getId());
    }

    private function assertSaveWithNamespaceCacheCollectedData(
        SaveWithNamespaceCacheCollectedData $expected,
        SaveWithNamespaceCacheCollectedData $actual
    ) {
        $this->assertSaveCacheCollectedData($expected, $actual);
        Assert::assertEquals($expected->getNamespaceId(), $actual->getNamespaceId());
    }
}
