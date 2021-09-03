<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Generator;

use Closure;
use Freezemage\Container\Contract\GeneratorInterface;
use Freezemage\Container\Exception\FactoryReturnTypeMismatchException;
use ReflectionClass;
use ReflectionFunction;

class FactoryGenerator implements GeneratorInterface
{
    private GeneratorInterface $generator;

    public function __construct(GeneratorInterface $generator) {
        $this->generator = $generator;
    }

    public function generate(ReflectionClass $reflection, array $dependencies = array()): object
    {
        $factory = reset($dependencies); // leaves dependencies array intact

        if (!is_callable($factory)) {
            return $this->generator->generate($reflection, $dependencies);
        }

        array_shift($dependencies); // removing factory method

        $factory = Closure::fromCallable($factory);
        $factoryReflection = new ReflectionFunction($factory);
        $returnType = $factoryReflection->getReturnType();

        if ($returnType == null || $returnType->getName() != $reflection->getName()) {
            throw FactoryReturnTypeMismatchException::forClass($reflection->getName());
        }

        return call_user_func_array($factory, $dependencies);
    }
}