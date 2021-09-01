<?php


namespace Freezemage\Container\Contract;


use ReflectionClass;


interface GeneratorInterface
{
    /**
     * Encapsulates the object generation strategy.
     *
     * @param ReflectionClass $reflection
     * @param array $dependencies
     *
     * @return object
     */
    public function generate(ReflectionClass $reflection, array $dependencies = array()): object;
}