<?php


namespace Freezemage\Container\Storage;

class Alias
{
    private array $storage;

    public function __construct(array $storage = array())
    {
        $this->storage = $storage;
    }

    public function register(string $identifier, string $className): void
    {
        $this->storage[$identifier] = $className;
    }

    public function get(string $identifier): string
    {
        return $this->storage[$identifier] ?? $identifier;
    }
}