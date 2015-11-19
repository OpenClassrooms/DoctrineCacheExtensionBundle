[![Build Status](https://travis-ci.org/OpenClassrooms/DoctrineCacheExtensionBundle.svg)](https://travis-ci.org/OpenClassrooms/DoctrineCacheExtensionBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c4488874-8c9c-40db-9b2e-9a8f510bbc14/mini.png)](https://insight.sensiolabs.com/projects/c4488874-8c9c-40db-9b2e-9a8f510bbc14)
[![Coverage Status](https://coveralls.io/repos/OpenClassrooms/DoctrineCacheExtension/badge.svg?branch=master&service=github)](https://coveralls.io/github/OpenClassrooms/DoctrineCacheExtension?branch=master)

The DoctrineCacheExtensionBundle provides integration of the DoctrineCacheExtension library.
DoctrineCacheExtension provides facilities to manage cache managment:
* Default lifetime
* Fetch with a namespace
* Save with a namespace
* Cache invalidation through namespace strategy
* Data collector available in the profiler (not implemented yet) 

See [OpenClassrooms/DoctrineCacheExtension](https://github.com/OpenClassrooms/DoctrineCacheExtension) for more details.

## Installation
This bundle can be installed using composer:

```composer require openclassrooms/doctrine-cache-extension-bundle```
or by adding the package to the composer.json file directly.

```json
{
    "require": {
        "openclassrooms/doctrine-cache-extension-bundle": "*"
    }
}
```

After the package has been installed, add the bundle to the AppKernel.php file:

```php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\OpenClassroomsDoctrineCacheExtensionBundle(),
    // ...
);
```

## Configuration
```yaml
doctrine_cache_extension:
    default_lifetime: 10 #optional, default = 0
```
## Usage
The configured cache is available as ```openclassrooms.cache.cache``` service:
```php
$cache = $container->get('openclassrooms.cache.cache');

$cache->fetch($id);
$cache->fetchWithNamespace($id, $namespaceId);
$cache->save($id, $data);
$cache->saveWithNamespace($id, $data, $namespaceId);
$cache->invalidate($namespaceId);

```

The configured cache provider is available as ```openclassrooms.cache.cache_provider``` service:
```php
$cacheProvider = $container->get('openclassrooms.cache.cache_provider');
```

The cache provider builder is available as ```openclassrooms.cache.cache_provider``` service:
```php
$builder = $container->get('openclassrooms.cache.cache_provider_builder');

// Redis
$cacheProvider = $builder
    ->create(CacheProviderType::REDIS)
    ->withHost('127.0.0.1')
    ->withPort(6379) // Default 6379
    ->withTimeout(0.0) // Default 0.0
    ->build();
```

See [Doctrine/DoctrineCacheBundle](https://github.com/doctrine/DoctrineCacheBundle) for more details.


