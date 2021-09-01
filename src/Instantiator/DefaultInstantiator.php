<?php


namespace Freezemage\Container\Instantiator;

use Freezemage\Container\Contract\InstantiatorInterface;


class DefaultInstantiator implements InstantiatorInterface
{
    public function instantiate(object $prototype): object
    {
        return $prototype;
    }
}