[![Build Status](https://travis-ci.org/OpenClassrooms/DoctrineCacheExtensionBundle.svg)](https://travis-ci.org/OpenClassrooms/DoctrineCacheExtensionBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c4488874-8c9c-40db-9b2e-9a8f510bbc14/mini.png)](https://insight.sensiolabs.com/projects/c4488874-8c9c-40db-9b2e-9a8f510bbc14)
[![Coverage Status](https://coveralls.io/repos/OpenClassrooms/DoctrineCacheExtension/badge.svg?branch=master&service=github)](https://coveralls.io/github/OpenClassrooms/DoctrineCacheExtension?branch=master)

The DoctrineCacheExtensionBundle offers integration of the DoctrineCacheExtension library.
DoctrineCacheExtension provides functionality to handle cache management:
* Default lifetime
* Fetch with a namespace
* Save with a namespace
* Cache invalidation through namespace strategy
* Data collector available in the profiler (not implemented yet) 

See [OpenClassrooms/DoctrineCacheExtension](https://github.com/OpenClassrooms/DoctrineCacheExtension) for more details.

## Installation
This bundle can be installed using composer:

```composer require openclassrooms/doctrine-cache-extension-bundle```
or by adding the package directly to the composer.json file.

```json
{
    "require": {
        "openclassrooms/doctrine-cache-extension-bundle": "*"
    }
}
```

After the package has been installed, add the bundle and the DoctrineCacheBundle to the AppKernel.php file:

```php
// in AppKernel::registerBundles()
$bundles = [
    // ...
    new new \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle();
    new OpenClassrooms\Bundle\DoctrineCacheExtensionBundle\OpenClassroomsDoctrineCacheExtensionBundle(),
    // ...
)];
```

## Configuration
```yaml
# app/config/config.yml

doctrine_cache_extension:
    default_lifetime: 10 #optional, default = 0
```
To configure the cache providers, use the [DoctrineCacheBundle configuration](https://github.com/doctrine/DoctrineCacheBundle#provider-configuration).
For example:

```yaml
# app/config/config.yml

doctrine_cache:
    providers:
        a_cache_provider:
            type: array
```

## Usage
```php
$cache = $container->get('doctrine_cache.providers.a_cache_provider');

$cache->fetch($id);
$cache->fetchWithNamespace($id, $namespaceId);
$cache->save($id, $data);
$cache->saveWithNamespace($id, $data, $namespaceId);
$cache->invalidate($namespaceId);

```
## Profiler
The bundle provides data in the profiler such as the number of calls, kinds of calls, and more.
(picture)
