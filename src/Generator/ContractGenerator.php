<?php


namespace Freezemage\Container\Generator;


use Freezemage\Container\Contract\Constructable;
use Freezemage\Container\Contract\GeneratorInterface;
use Freezemage\Container\Contract\Settable;
use Freezemage\Container\Exception\ContainerException;
use Freezemage\Container\Exception\NoGenerationContractException;
use ReflectionClass;


class ContractGenerator implements GeneratorInterface
{
    private SetterGenerator $setter;
    private ConstructorGenerator $constructor;

    public function __construct()
    {
        $this->setter = new SetterGenerator();
        $this->constructor = new ConstructorGenerator();
    }

    public function generate(ReflectionClass $reflection, array $dependencies = array()): object
    {
        if ($reflection->implementsInterface(Constructable::class)) {
            return $this->constructor->generate($reflection, $dependencies);
        }

        if ($reflection->implementsInterface(Settable::class)) {
            return $this->setter->generate($reflection, $dependencies);
        }

        throw NoGenerationContractException::forClass($reflection->getName());
    }
}