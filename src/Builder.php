<?php
/** @author Demyan Seleznev <seleznev@intervolga.ru> */

namespace Freezemage\Container;

use Freezemage\Container\Configuration\Cache;
use Freezemage\Container\Configuration\Config;
use Freezemage\Container\Configuration\Dependencies;
use Freezemage\Container\Configuration\FactoryClass;
use Freezemage\Container\Configuration\Strategy;
use Freezemage\Container\Contract\GeneratorInterface;
use Freezemage\Container\Contract\InstantiatorInterface;
use Freezemage\Container\Contract\ResolverInterface;
use Freezemage\Container\Exception\ContainerException;
use Freezemage\Container\Factory\GeneratorFactory;
use Freezemage\Container\Factory\InstantiatorFactory;
use Freezemage\Container\Factory\ResolverFactory;
use Freezemage\Container\Generator\FactoryGenerator;
use ReflectionClass;

class Builder {
    private FactoryClass $generatorFactory;
    private FactoryClass $instantiatorFactory;
    private FactoryClass $resolverFactory;
    private Cache        $cacheGenerator;
    private Cache        $cacheResolver;
    private Strategy     $generatorStrategy;
    private Strategy     $instantiatorStrategy;
    private Strategy     $resolverStrategy;
    private Dependencies $dependencies;

    public static function fromConfig(Config $config): Builder
    {
        $builder = new Builder();
        $builder->generatorFactory = $config->getGeneratorFactory();
        $builder->instantiatorFactory = $config->getInstantiatorFactory();
        $builder->resolverFactory = $config->getResolverFactory();
        $builder->generatorStrategy = $config->getGeneratorStrategy();
        $builder->instantiatorStrategy = $config->getInstantiatorStrategy();
        $builder->resolverStrategy = $config->getResolverStrategy();
        $builder->cacheGenerator = $config->getCacheGenerator();
        $builder->cacheResolver = $config->getCacheResolver();
        $builder->dependencies = $config->getDependencies();

        return $builder;
    }

    public function __construct() {
        $this->generatorFactory = new FactoryClass(GeneratorFactory::class);
        $this->instantiatorFactory = new FactoryClass(InstantiatorFactory::class);
        $this->resolverFactory = new FactoryClass(ResolverFactory::class);

        $this->generatorStrategy = new Strategy('constructor');
        $this->instantiatorStrategy = new Strategy('clone');
        $this->resolverStrategy = new Strategy('constructor');

        $this->cacheGenerator = new Cache(false);
        $this->cacheResolver = new Cache(true);

        $this->dependencies = new Dependencies();
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

    public function build(): Container {
        $container = new Container();

        $container->setGenerator(new FactoryGenerator($this->createGenerator()));
        $container->setInstantiator($this->createInstantiator());
        $container->setResolver($this->createResolver());

        foreach ($this->getDependencies() as $dependency) {

        }

        return $container;
    }

    private function createGenerator(): GeneratorInterface
    {
        $reflection = new ReflectionClass($this->generatorFactory->getName());

        if ($reflection->getName() != GeneratorFactory::class) {
            if (!$reflection->isSubclassOf(GeneratorFactory::class)) {
                throw new ContainerException('Unable to create generator factory.');
            }
        }

        /** @var GeneratorFactory $factory */
        $factory = $reflection->newInstance();
        return $factory->create($this->generatorStrategy->getName());
    }

    private function createResolver(): ResolverInterface
    {
        $reflection = new ReflectionClass($this->resolverFactory->getName());

        if ($reflection->getName() != ResolverFactory::class) {
            if (!$reflection->isSubclassOf(ResolverFactory::class)) {
                throw new ContainerException('Unable to create resolver factory.');
            }
        }

        $factory = $reflection->newInstance();
        return $factory->create($this->resolverStrategy->getName());
    }

    private function createInstantiator(): InstantiatorInterface
    {
        $reflection = new ReflectionClass($this->instantiatorFactory->getName());

        if ($reflection->getName() != InstantiatorFactory::class ) {
            if (!$reflection->isSubclassOf(InstantiatorFactory::class)) {
                throw new ContainerException('Unable to create instantiator factory.');
            }
        }

        $factory = $reflection->newInstance();
        return $factory->create($this->instantiatorStrategy->getName());
    }
}