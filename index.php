<?php


use Freezemage\Container\Container;
use Freezemage\Container\Example\Proxy;


require __DIR__ . '/vendor/autoload.php';

$container = new Container();
$proxy = $container->get(Proxy::class);


function debug(callable $f): float
{
    $begin = microtime(true);
    $f();
    $end = microtime(true);

    return $end - $begin;
}

$warmUp = debug(function () use ($container) {
    $container->get(Proxy::class);
});

$hit = debug(function () use ($container) {
    $container->get(Proxy::class);
});

var_dump(array(
    'hit' => $hit,
    'warmUp' => $warmUp,
    'difference' => abs($warmUp - $hit)
));