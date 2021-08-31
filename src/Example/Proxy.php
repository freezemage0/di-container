<?php


namespace Freezemage\Container\Example;

class Proxy
{
    private Primitive $primitive;

    public function __construct(Primitive $primitive)
    {
        $this->primitive = $primitive;
    }

    public function getPrimitive(): Primitive
    {
        return $this->primitive;
    }
}