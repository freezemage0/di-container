<?php


namespace Freezemage\Container\Generator;


use Freezemage\Container\Contract\GeneratorInterface;
use ReflectionClass;


class SetterGenerator implements GeneratorInterface
{
    public function generate(ReflectionClass $reflection, array $dependencies = array()): object
    {
        $instance = $reflection->newInstance();

        foreach ($dependencies as $name => $value) {
            $method = $reflection->getMethod($name);
            $method->invoke($instance, $value);
        }

        return $instance;
    }
}