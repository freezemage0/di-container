<?php


namespace Freezemage\Container\Storage;


use Freezemage\Container\Exception\ContainerException;


class PrototypeCache
{
    private array $cache;

    public function __construct()
    {
        $this->cache = array();
    }

    public function set(string $className, object $instance): void
    {
        $this->cache[$className] = $instance;
    }

    public function get(string $className): object
    {
        if (!$this->has($className)) {
            throw new ContainerException(); // todo: not found exception
        }

        return $this->cache[$className];
    }

    public function has(string $className): bool
    {
        return array_key_exists($className, $this->cache);
    }
}