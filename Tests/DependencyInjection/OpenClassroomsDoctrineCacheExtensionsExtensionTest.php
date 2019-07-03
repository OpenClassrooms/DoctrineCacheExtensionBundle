<?php

namespace OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\Tests\DependencyInjection;

use Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection\DoctrineCacheExtension;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\DependencyInjection\OpenClassroomsDoctrineCacheExtensionExtension;
use OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\OpenClassroomsDoctrineCacheExtensionBundle;
use OpenClassrooms\DoctrineCacheExtension\CacheProviderDecorator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsDoctrineCacheExtensionsExtensionTest extends TestCase
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
            ['Doctrine\Common\Cache\PhpFileCache', 'doctrine_cache.providers.my_php_file_cache', 'phpfile'],
            ['Doctrine\Common\Cache\RedisCache', 'doctrine_cache.providers.my_redis_cache', 'redis'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tearDownAfterClass()
    {
        $tmpDirectory = __DIR__ . '/../tmp';
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
            $this->markTestSkipped('The ' . __CLASS__ . ' requires the use of memcache');
        }
        if ('memcached' === $type && !extension_loaded('memcached')) {
            $this->markTestSkipped('The ' . __CLASS__ . ' requires the use of memcached');
        }
        if ('redis' === $type && !extension_loaded('redis')) {
            $this->markTestSkipped('The ' . __CLASS__ . ' requires the use of redis');
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
        $factory = $this->container->get('oc.doctrine_cache_extensions.cache_provider_decorator_factory');
        $this->assertAttributeEquals(100, 'defaultLifetime', $factory);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $container = new ContainerBuilder();
        $extension = new OpenClassroomsDoctrineCacheExtensionExtension();
        $container->registerExtension($extension);
        $container->registerExtension(new DoctrineCacheExtension());
        $container->loadFromExtension('doctrine_cache_extension');

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Fixtures/Resources/config'));
        $loader->load('config.yml');
        $serviceLoader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Fixtures/Resources/config'));
        $serviceLoader->load('services.xml');

        $bundle = new OpenClassroomsDoctrineCacheExtensionBundle();
        $bundle->build($container);

        $container->compile();
        $this->container = $container;
    }
}
