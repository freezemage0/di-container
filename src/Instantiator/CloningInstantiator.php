<?php


namespace Freezemage\Container\Instantiator;


use Freezemage\Container\Contract\InstantiatorInterface;
use Freezemage\Container\Exception\NotCloneableObjectException;
use ReflectionObject;


class CloningInstantiator implements InstantiatorInterface
{
    public function instantiate(object $prototype): object
    {
        $reflection = new ReflectionObject($prototype);
        if (!$reflection->isCloneable()) {
            throw new NotCloneableObjectException(sprintf('Instance of %s cannot be cloned.', $reflection->getName()));
        }

        return clone $prototype;
    }
}