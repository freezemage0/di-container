<?php


namespace Freezemage\Container\Resolver;


use Freezemage\Container\Contract\ResolverInterface;
use ReflectionClass;


class NullResolver implements ResolverInterface
{
    /**
     * Does not resolve shit.
     * Always returns empty dependencies set because FUCK YOU!
     *
     * @param ReflectionClass $reflection
     *
     * @return array
     */
    public function resolve(ReflectionClass $reflection): array
    {
        return array();
    }
}