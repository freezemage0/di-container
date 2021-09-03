<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Configuration;

use Freezemage\Container\Exception\ContainerException;

class FactoryClass {
    private string $name;

    public function __construct(string $name) {
        if (!class_exists($name)) {
            throw new ContainerException('Unknown generator factory.');
        }
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }
}