<?php

return array(
        'instantiator' => 'copy',
        'generator' => 'contract',
        'resolver' => 'constructor',
        'cacheResolver' => true,
        'cacheGenerator' => true,
        'dependencies' => array(
                'proxy' => array(
                        'className' => '\\Freezemage\\Container\\Example\\Proxy',
                        'parameters' => array('\\Freezemage\\Container\\Example\\Primitive')
                ),
                '\\Freezemage\\Container\\Example\\Primitive' => array(
                        'parameters' => array(),
                        'factory' => array('\\Freezemage\\Container\\Example\\PrimitiveFactory', 'create')
                )
        )
);