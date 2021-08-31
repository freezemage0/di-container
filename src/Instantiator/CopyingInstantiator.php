<?php


namespace Freezemage\Container\Instantiator;


use Freezemage\Container\Contract\InstantiatorInterface;
use ReflectionObject;


class CopyingInstantiator implements InstantiatorInterface
{
    public function instantiate(object $prototype): object
    {
        $reflection = new ReflectionObject($prototype);
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($prototype);

            $property->setValue(
                $instance,
                is_object($value) ? $this->instantiate($value) : $value
            );
        }

        return $instance;
    }
}