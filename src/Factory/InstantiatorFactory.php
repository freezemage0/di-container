<?php


namespace Freezemage\Container\Factory;

use Freezemage\Container\Contract\InstantiatorInterface;
use Freezemage\Container\Exception\ContainerException;
use Freezemage\Container\Exception\UnknownStrategyTypeException;
use Freezemage\Container\Instantiator\CloningInstantiator;
use Freezemage\Container\Instantiator\CopyingInstantiator;
use Freezemage\Container\Instantiator\DefaultInstantiator;


class InstantiatorFactory
{
    private array $types;

    public function __construct()
    {
        $this->types = array_merge(
            $this->registerDefaultTypes(),
            $this->registerCustomTypes()
        );
    }

    public function create(string $type): InstantiatorInterface
    {
        if (!array_key_exists($type, $this->types)) {
            throw UnknownStrategyTypeException::create('Instantiator', $type);
        }

        return clone $this->types[$type];
    }

    private function registerDefaultTypes(): array
    {
        return array(
            'clone' => new CloningInstantiator(),
            'copy' => new CopyingInstantiator(),
            'default' => new DefaultInstantiator()
        );
    }

    protected function registerCustomTypes(): array
    {
        return array();
    }
}