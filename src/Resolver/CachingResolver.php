<?php


namespace Freezemage\Container\Resolver;


use Freezemage\Container\Contract\ResolverInterface;
use ReflectionClass;

/**
 * Decorates the {@link ResolverInterface} instance and caches its output.
 */
class CachingResolver implements ResolverInterface
{
    private array $cache;
    private ResolverInterface $resolver;

    public function __construct(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        $this->cache = array();
    }

    public function resolve(ReflectionClass $reflection): array
    {
        $className = $reflection->getName();

        if (array_key_exists($className, $this->cache)) {
            return $this->cache[$className];
        }

        return $this->cache[$className] = $this->resolver->resolve($reflection);
    }
}