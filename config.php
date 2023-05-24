<?php


return array(
    /*
     * This configuration determines the generation and instantiation strategies.
     *
     * When resolver determines the dependencies, it creates the Prototype of the class using Generator.
     * Generator may create Prototypes using constructor, setter or interface strategies.
     * 'generator' value defaults to 'constructor', may be 'constructor', 'setter' or 'contract'.
     * Contract strategy uses 'constructor' or 'setter' strategy.
     * It will use 'constructor' strategy if class implements 'Constructable' contract or
     * 'setter' strategy if class implements 'Settable' contract.
     * The contract strategy will throw "NoStrategyInterfaceException" if class does not implement any contract.
     *
     * The Prototype is passed to Instantiator, which creates real object instance.
     * This helps with the cache of resolved identifiers.
     *
     * Default instantiator immediately returns the Prototype.
     */
    'prototype' => array(
        'instantiator' => 'copy',
        'generator' => 'constructor'
    ),
    'resolver' => array(
        /*
         * Determines the strategy that will be used when the dependency cannot be resolved from configuration.
         * Defaults to null, may be 'constructor', 'setter' or null.
         */
        'fallback' => 'constructor'
    ),
    'dependencies' => array(
        /*
         * Keys within this array determine the identifiers that will be passed to Container::get().
         */
        '\\Freezemage\\Persistence\\ConnectionInterface' => array(
            /*
             * If the className is not defined, the declared identifier will be used as class name instead.
             */
            'className' => '\\Freezemage\\Persistence\\MysqliConnection',
            'dependencies' => array('\\Freezemage\\Config\\ImmutableConfig')
        ),
        '\\Freezemage\\Config\\ImmutableConfig' => array(
            /*
             * Values provided within 'factory' key MUST be of type callables.
             */
            'factory' => array('\\Freezemage\\Config\\ConfigFactory', 'create')
        )
    )
);