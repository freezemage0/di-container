<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Storage;

use Freezemage\Container\Exception\NotFoundException;

class Definitions {
    private array $definitions;

    public function __construct()
    {
        $this->definitions = array();
    }

    public function register(string $className, array $dependencies = array()): void
    {
        $this->definitions[$className] = $dependencies;
    }

    public function get(string $className): array
    {
        if (!$this->has($className)) {
            throw new NotFoundException(sprintf('Definition for class %s not found.', $className));
        }

        return $this->definitions[$className];
    }

    public function has(string $className): bool
    {
        return array_key_exists($className, $this->definitions);
    }
}