<?php


namespace Freezemage\Container\Factory;

use Freezemage\Container\Contract\GeneratorInterface;
use Freezemage\Container\Exception\ContainerException;
use Freezemage\Container\Exception\UnknownStrategyTypeException;
use Freezemage\Container\Generator\ConstructorGenerator;
use Freezemage\Container\Generator\ContractGenerator;
use Freezemage\Container\Generator\SetterGenerator;


class GeneratorFactory
{
    private array $types;

    final public function __construct()
    {
        $this->types = array_merge(
            $this->registerDefaultTypes(),
            $this->registerCustomTypes()
        );
    }

    public function create(string $type): GeneratorInterface
    {
        if (!array_key_exists($type, $this->types)) {
            throw UnknownStrategyTypeException::create('Generator', $type);
        }

        return clone $this->types[$type];
    }

    private function registerDefaultTypes(): array
    {
        return array(
            'constructor' => new ConstructorGenerator(),
            'setter' => new SetterGenerator(),
            'contract' => new ContractGenerator()
        );
    }

    protected function registerCustomTypes(): array
    {
        return array();
    }
}