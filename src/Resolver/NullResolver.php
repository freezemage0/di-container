<?php


namespace Freezemage\Container\Resolver;


use Freezemage\Container\Contract\ResolverInterface;
use ReflectionClass;

/**
 * Default fallback resolver for {@link ConfigurationResolver}.
 */
class NullResolver implements ResolverInterface
{
    public function resolve(ReflectionClass $reflection): array
    {
        return array();
    }
}