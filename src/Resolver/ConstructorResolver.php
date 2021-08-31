<?php


namespace Freezemage\Container\Resolver;


use Freezemage\Container\Contract\ResolverInterface;
use Freezemage\Container\Exception\ContainerException;
use ReflectionClass;


class ConstructorResolver implements ResolverInterface
{
    public function resolve(ReflectionClass $reflection): array
    {
        $constructor = $reflection->getConstructor();

        if ($constructor == null) {
            return array();
        }

        $parameters = $constructor->getParameters();

        $dependencies = array();
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            $name = $parameter->getName();

            if (!$parameter->getType()->isBuiltin()) {
                $dependencies[$name] = $type->getName();
            }
        }

        return $dependencies;
    }
}