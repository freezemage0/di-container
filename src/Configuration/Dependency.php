<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Configuration;

class Dependency {
    private string $className;
    private string $alias;
    private array $parameters;
    private array $definition;

    public function __construct(
            string $className,
            string $alias,
            array  $parameters = array(),
            array  $definition = array()
    ) {
        $this->className = $className;
        $this->alias = $alias;
        $this->parameters = $parameters;
        $this->definition = $definition;
    }

    public function getClassName(): string {
        return $this->className;
    }

    public function getAlias(): string {
        return $this->alias;
    }

    public function getDefinition(): array {
        return $this->definition;
    }

    public function getParameters(): array {
        return $this->parameters;
    }
}