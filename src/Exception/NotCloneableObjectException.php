<?php


namespace Freezemage\Container\Exception;


use Exception;
use Psr\Container\ContainerExceptionInterface;


class NotCloneableObjectException extends Exception implements ContainerExceptionInterface
{

}