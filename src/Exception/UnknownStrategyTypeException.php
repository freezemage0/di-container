<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Exception;


class UnknownStrategyTypeException extends NotFoundException
{
    public static function create(string $type, string $strategy): UnknownStrategyTypeException
    {
        return new UnknownStrategyTypeException(
                sprintf('Cannot create instanceof of `%s`: unknown type - `%s`', $type, $strategy)
        );
    }
}