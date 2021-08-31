<?php


namespace Freezemage\Container\Contract;

interface InstantiatorInterface
{
    /**
     * Returns concrete instance from the prototype.
     * Created instance MUST be the same type as the prototype.
     *
     * @param object $prototype
     *
     * @return object
     */
    public function instantiate(object $prototype): object;
}