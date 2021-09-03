<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Exception;

class FactoryReturnTypeMismatchException extends ContainerException
{
    public static function forClass(string $className): FactoryReturnTypeMismatchException
    {
        return new FactoryReturnTypeMismatchException(
                sprintf('Factory method for class %s does not return instances of %s', $className, $className)
        );
    }
}