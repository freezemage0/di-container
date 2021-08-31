<?php


namespace Freezemage\Container\Contract;


use ReflectionClass;


interface ResolverInterface
{
    public function resolve(ReflectionClass $reflection): array;
}