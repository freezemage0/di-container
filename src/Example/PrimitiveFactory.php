<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Example;

class PrimitiveFactory {
    public static function create(int $value): Primitive
    {
        return new Primitive($value);
    }
}