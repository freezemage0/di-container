<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Generator;

use Freezemage\Container\Contract\GeneratorInterface;
use ReflectionClass;

class CachingGenerator implements GeneratorInterface {
    private array $cache;
    private GeneratorInterface $generator;

    public function __construct(GeneratorInterface $generator)
    {
        $this->generator = $generator;
        $this->cache = array();
    }

    public function generate(ReflectionClass $reflection, array $dependencies = array()): object
    {
        $className = $reflection->getName();

        if (array_key_exists($className, $this->cache)) {
            return $this->cache[$className];
        }

        return $this->cache[$className] = $this->generator->generate($reflection, $dependencies);
    }
}