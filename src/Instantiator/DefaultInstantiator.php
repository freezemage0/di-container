<?php


namespace Freezemage\Container\Instantiator;

use Freezemage\Container\Contract\InstantiatorInterface;


class DefaultInstantiator implements InstantiatorInterface
{
    /**
     * This lazy fuck doesn't even do shit, just returns passed argument.
     *
     * @param object $prototype
     *
     * @return object
     */
    public function instantiate(object $prototype): object
    {
        return $prototype;
    }
}