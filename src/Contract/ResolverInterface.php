<?php


namespace Freezemage\Container\Contract;


use ReflectionClass;


interface ResolverInterface
{
    /**
     * Returns the dependencies for passed {@link ReflectoinClass} instance.
     * Returned dependencies MUST be in the same order as declared constructor parameters or setter methods.
     * Empty array SHOULD be treated as "class has no dependencies" case.
     *
     * @param ReflectionClass $reflection
     * @return array
     */
    public function resolve(ReflectionClass $reflection): array;
}