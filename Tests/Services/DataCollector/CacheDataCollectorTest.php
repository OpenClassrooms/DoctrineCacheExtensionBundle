<?php

namespace Services\DataCollector;

use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheCollectedData\FetchCacheCollectedData;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\CacheDataCollector;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Services\DataCollector\DebugCacheProviderDecorator;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\CacheCollectedDataTestCase;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\FetchCacheCollectedDataStub;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\Doubles\Services\DataCollector\CacheCollectedData\SaveCacheCollectedDataStub;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheDataCollectorTest extends \PHPUnit_Framework_TestCase
{
    use CacheCollectedDataTestCase;

    /**
     * @var CacheDataCollector
     */
    private $cacheDataCollector;

    /**
     * @test
     */
    public function WithoutCollectedData_getAllFetchQueries_ReturnEmpty()
    {
        DebugCacheProviderDecorator::$collectedData = [];
        $this->cacheDataCollector->collect(Request::create('test'), Response::create());
        $this->assertEquals(0, $this->cacheDataCollector->getAllFetchQueriesCount());
        $this->assertEquals(0, $this->cacheDataCollector->getAllFetchQueriesDuration());
    }

    /**
     * @test
     */
    public function getAllFetchQueries_ReturnData()
    {
        $this->assertEquals(1, $this->cacheDataCollector->getAllFetchQueriesCount());
        $this->assertEquals(1, $this->cacheDataCollector->getAllFetchQueriesDuration());
    }

    /**
     * @test
     */
    public function WithoutCollectedData_getAllSaveQueries_ReturnEmpty()
    {
        DebugCacheProviderDecorator::$collectedData = [];
        $this->cacheDataCollector->collect(Request::create('test'), Response::create());
        $this->assertEquals(0, $this->cacheDataCollector->getAllSaveQueriesCount());
        $this->assertEquals(0, $this->cacheDataCollector->getAllSaveQueriesDuration());
    }

    /**
     * @test
     */
    public function getAllSaveQueries_ReturnData()
    {
        $this->assertEquals(1, $this->cacheDataCollector->getAllSaveQueriesCount());
        $this->assertEquals(1, $this->cacheDataCollector->getAllSaveQueriesDuration());
    }

    /**
     * @test
     */
    public function WithoutCollectedData_getAllQueries_ReturnEmpty()
    {
        DebugCacheProviderDecorator::$collectedData = [];
        $this->cacheDataCollector->collect(Request::create('test'), Response::create());
        $this->assertEquals(0, $this->cacheDataCollector->getAllQueriesCount());
        $this->assertEquals(0, $this->cacheDataCollector->getAllQueriesDuration());
    }

    /**
     * @test
     */
    public function getAllQueries_ReturnData()
    {
        $this->assertEquals(2, $this->cacheDataCollector->getAllQueriesCount());
        $this->assertEquals(2, $this->cacheDataCollector->getAllQueriesDuration());
    }

    /**
     * @test
     */
    public function WithoutCollectedData_getQueriesDetails_ReturnEmpty()
    {
        DebugCacheProviderDecorator::$collectedData = [];
        $this->cacheDataCollector->collect(Request::create('test'), Response::create());
        $this->assertCount(0, $this->cacheDataCollector->getQueriesDetails());
    }

    /**
     * @test
     */
    public function getQueriesDetails_ReturnData()
    {
        $queriesDetails = $this->cacheDataCollector->getQueriesDetails();
        $this->assertArrayHasKey(FetchCacheCollectedDataStub::PROVIDER_ID, $queriesDetails);
        $this->assertCacheCollectedData(
            [$this->buildFetchQueryStub(), $this->buildSaveQueryStub()],
            $queriesDetails[FetchCacheCollectedDataStub::PROVIDER_ID]
        );
    }

    /**
     * @return FetchCacheCollectedData
     */
    protected function buildFetchQueryStub()
    {
        $fetchCacheCollectedDataStub = new FetchCacheCollectedDataStub();
        $fetchCacheCollectedDataStub->setStart(1);
        $fetchCacheCollectedDataStub->setStop(2);

        return $fetchCacheCollectedDataStub;
    }

    /**
     * @return FetchCacheCollectedData
     */
    protected function buildSaveQueryStub()
    {
        $saveCacheCollectedDataStub = new SaveCacheCollectedDataStub();
        $saveCacheCollectedDataStub->setStart(1);
        $saveCacheCollectedDataStub->setStop(2);

        return $saveCacheCollectedDataStub;
    }

    /**
     * @test
     */
    public function getName_ReturnName()
    {
        $this->assertEquals(CacheDataCollector::NAME, $this->cacheDataCollector->getName());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        DebugCacheProviderDecorator::$collectedData[0] = $this->buildFetchQueryStub();
        DebugCacheProviderDecorator::$collectedData[1] = $this->buildSaveQueryStub();

        $this->cacheDataCollector = new CacheDataCollector();
        $this->cacheDataCollector->collect(Request::create('test'), Response::create());
    }
}
