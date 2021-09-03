<?php


use Freezemage\Container\Builder;
use Freezemage\Container\Example\Primitive;
use Freezemage\Container\Example\Proxy;


require __DIR__ . '/vendor/autoload.php';

$container = (new Builder())->build();
$container->alias('proxy', Proxy::class);
$container->define(Primitive::class, array('value' => 123));
$proxy = $container->get('proxy');

var_dump($proxy);