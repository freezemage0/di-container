<?php


namespace Freezemage\Container\Factory;

use Freezemage\Container\Contract\ResolverInterface;
use Freezemage\Container\Exception\ContainerException;
use Freezemage\Container\Resolver\ConstructorResolver;
use Freezemage\Container\Resolver\NullResolver;
use Freezemage\Container\Resolver\SetterResolver;


class ResolverFactory
{
    private array $types;

    public function __construct()
    {
        $this->types = array_merge(
            $this->registerDefaultTypes(),
            $this->registerCustomTypes()
        );
    }

    public function create(string $type): ResolverInterface
    {
        if (!array_key_exists($type, $this->types)) {
            throw new ContainerException('Unable to create Resolver of type ' . $type);
        }

        return clone $this->types[$type];
    }

    private function registerDefaultTypes(): array
    {
        return array(
            'constructor' => new ConstructorResolver(),
            'setter' => new SetterResolver(),
            'default' => new NullResolver()
        );
    }

    protected function registerCustomTypes(): array
    {
        return array();
    }
}