<?php


namespace Freezemage\Container\Generator;


use Freezemage\Container\Contract\GeneratorInterface;
use ReflectionClass;
use ReflectionParameter;


class ConstructorGenerator implements GeneratorInterface
{
    public function generate(ReflectionClass $reflection, array $dependencies = array()): object
    {
        $constructor = $reflection->getConstructor();
        if ($constructor == null) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = array_map(
            function (ReflectionParameter $parameter) use ($dependencies) {
                return $dependencies[$parameter->getName()] ?? null;
            },
            $parameters
        );

        return $reflection->newInstanceArgs($dependencies);
    }
}