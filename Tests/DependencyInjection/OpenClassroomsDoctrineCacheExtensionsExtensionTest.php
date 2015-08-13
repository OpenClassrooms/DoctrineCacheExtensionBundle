<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\DependencyInjection;

use Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection\DoctrineCacheExtension;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\OpenClassroomsDoctrineCacheExtensionExtension;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\OpenClassroomsDoctrineCacheExtensionBundle;
use OpenClassrooms\DoctrineCacheExtension\CacheProviderDecorator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsDoctrineCacheExtensionsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @return array
     */
    public static function cacheProvider()
    {
        return [
            ['Doctrine\Common\Cache\ArrayCache', 'doctrine_cache.providers.my_array_cache', 'array'],
            ['Doctrine\Common\Cache\FilesystemCache', 'doctrine_cache.providers.my_filesystem_cache', 'filesystem'],
            ['Doctrine\Common\Cache\MemcacheCache', 'doctrine_cache.providers.my_memcache_cache', 'memcache'],
            ['Doctrine\Common\Cache\MemcachedCache', 'doctrine_cache.providers.my_memcached_cache', 'memcached'],
            ['Doctrine\Common\Cache\MongoDBCache', 'doctrine_cache.providers.my_mongodb_cache', 'mongodb'],
            ['Doctrine\Common\Cache\PhpFileCache', 'doctrine_cache.providers.my_php_file_cache', 'phpfile'],
            ['Doctrine\Common\Cache\RedisCache', 'doctrine_cache.providers.my_redis_cache', 'redis'],
            ['Doctrine\Common\Cache\RiakCache', 'doctrine_cache.providers.my_riak_cache', 'riak'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tearDownAfterClass()
    {
        $tmpDirectory = __DIR__.'/../tmp';
        if (is_dir($tmpDirectory)) {
            rmdir($tmpDirectory);
        }
    }

    /**
     * @test
     * @dataProvider cacheProvider
     */
    public function CacheProviderDecorator($expectedCache, $inputServiceName, $type)
    {
        $this->checkExtension($type);
        /** @var CacheProviderDecorator $cacheProviderDecorator */
        $cacheProviderDecorator = $this->container->get($inputServiceName);
        $this->assertCacheProviderDecorator($expectedCache, $cacheProviderDecorator);
    }

    private function checkExtension($type)
    {
        if ('memcache' === $type && !extension_loaded('memcache')) {
            $this->markTestSkipped('The '.__CLASS__.' requires the use of memcache');
        }
        if ('memcached' === $type && !extension_loaded('memcached')) {
            $this->markTestSkipped('The '.__CLASS__.' requires the use of memcached');
        }
        if ('mongodb' === $type && !extension_loaded('mongo')) {
            $this->markTestSkipped('The '.__CLASS__.' requires the use of mongo');
        }
        if ('redis' === $type && !extension_loaded('redis')) {
            $this->markTestSkipped('The '.__CLASS__.' requires the use of redis');
        }
        if ('riak' === $type && !extension_loaded('riak')) {
            $this->markTestSkipped('The '.__CLASS__.' requires the use of riak');
        }
    }

    private function assertCacheProviderDecorator($expectedCache, CacheProviderDecorator $cacheProviderDecorator)
    {
        $this->assertInstanceOf('Doctrine\Common\Cache\CacheProvider', $cacheProviderDecorator);
        $this->assertInstanceOf(
            'OpenClassrooms\DoctrineCacheExtension\CacheProviderDecorator',
            $cacheProviderDecorator
        );
        $this->assertAttributeInstanceOf($expectedCache, 'cacheProvider', $cacheProviderDecorator);
    }

    /**
     * @test
     */
    public function GetCacheProviderDecoratorFactory()
    {
        $factory = $this->container->get('doctrine_cache_extensions.cache_provider_decorator_factory');
        $this->assertAttributeEquals(100, 'defaultLifetime', $factory);
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $extension = new OpenClassroomsDoctrineCacheExtensionExtension();
        $this->container->registerExtension($extension);
        $this->container->registerExtension(new DoctrineCacheExtension());
        $this->container->loadFromExtension('doctrine_cache_extension');

        $bundle = new OpenClassroomsDoctrineCacheExtensionBundle();
        $bundle->build($this->container);

        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../Fixtures/Yaml/'));
        $loader->load('config.yml');
        $this->container->compile();
    }
}
