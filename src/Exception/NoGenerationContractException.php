<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Exception;

class NoGenerationContractException extends NotFoundException
{
    public static function forClass(string $className): NoGenerationContractException
    {
        return new NoGenerationContractException(
                sprintf('Class `%s` does not implement any generation contract.', $className)
        );
    }
}