<?php


namespace Freezemage\Container\Resolver;


use Freezemage\Container\Contract\ResolverInterface;
use ReflectionClass;


class SetterResolver implements ResolverInterface
{
    public function resolve(ReflectionClass $reflection): array
    {
        $dependencies = array();
        foreach ($reflection->getMethods() as $method) {
            if (!$method->isPublic()) {
                continue;
            }

            if (substr($method->getName(), 0, 3) != 'set') {
                continue;
            }

            $parameters = $method->getParameters();
            $dependency = array_shift($parameters);
            if ($dependency == null) {
                continue;
            }

            $type = $dependency->getType();
            if ($type == null) {
                continue;
            }

            $dependencies[$dependency->getName()] = $type->getName();
        }

        return $dependencies;
    }
}