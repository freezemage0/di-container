<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Configuration;


use ArrayObject;
use Iterator;


class Dependencies implements Iterator {
    private ArrayObject $dependencies;
    private Iterator $innerIterator;

    public function __construct() {
        $this->dependencies = new ArrayObject();
    }

    public function addDependency(Dependency $dependency): void
    {
        $this->dependencies[] = $dependency;
    }

    public function current(): Dependency
    {
        return $this->innerIterator->current();
    }

    public function next(): void
    {
        $this->innerIterator->next();
    }

    public function key(): int
    {
        return $this->innerIterator->key();
    }

    public function valid(): bool
    {
        return $this->innerIterator->valid();
    }

    public function rewind(): void
    {
        $this->innerIterator = clone $this->dependencies->getIterator();
    }
}