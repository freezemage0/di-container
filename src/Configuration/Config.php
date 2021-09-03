<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container\Configuration;

class Config {
    private FactoryClass $generatorFactory;
    private FactoryClass $instantiatorFactory;
    private FactoryClass $resolverFactory;
    private Cache        $cacheGenerator;
    private Cache        $cacheResolver;
    private Strategy     $generatorStrategy;
    private Strategy     $instantiatorStrategy;
    private Strategy     $resolverStrategy;
    private Dependencies $dependencies;

    public function __construct(
            FactoryClass $generatorFactory,
            FactoryClass $instantiatorFactory,
            FactoryClass $resolverFactory,
            Cache        $cacheGenerator,
            Cache        $cacheResolver,
            Strategy     $generatorStrategy,
            Strategy     $instantiatorStrategy,
            Strategy     $resolverStrategy,
            Dependencies $dependencies
    ) {
        $this->generatorFactory = $generatorFactory;
        $this->instantiatorFactory = $instantiatorFactory;
        $this->resolverFactory = $resolverFactory;
        $this->cacheGenerator = $cacheGenerator;
        $this->cacheResolver = $cacheResolver;
        $this->generatorStrategy = $generatorStrategy;
        $this->instantiatorStrategy = $instantiatorStrategy;
        $this->resolverStrategy = $resolverStrategy;
        $this->dependencies = $dependencies;
    }

    public function getGeneratorFactory(): FactoryClass {
        return $this->generatorFactory;
    }

    public function getInstantiatorFactory(): FactoryClass {
        return $this->instantiatorFactory;
    }

    public function getResolverFactory(): FactoryClass {
        return $this->resolverFactory;
    }

    public function getCacheGenerator(): Cache {
        return $this->cacheGenerator;
    }

    public function getCacheResolver(): Cache {
        return $this->cacheResolver;
    }

    public function getGeneratorStrategy(): Strategy {
        return $this->generatorStrategy;
    }

    public function getInstantiatorStrategy(): Strategy {
        return $this->instantiatorStrategy;
    }

    public function getResolverStrategy(): Strategy {
        return $this->resolverStrategy;
    }

    public function getDependencies(): Dependencies {
        return $this->dependencies;
    }
}