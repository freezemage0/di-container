<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{

}