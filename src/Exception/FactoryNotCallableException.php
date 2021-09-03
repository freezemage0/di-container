<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Exception;

class FactoryNotCallableException extends ContainerException
{
    public static function forClass(string $className): FactoryNotCallableException
    {
        return new FactoryNotCallableException(
                sprintf('Factory method for class %s cannot be called.', $className)
        );
    }
}