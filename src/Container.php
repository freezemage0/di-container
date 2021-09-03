<?php


namespace Freezemage\Container;


use Freezemage\Container\Contract\GeneratorInterface;
use Freezemage\Container\Contract\InstantiatorInterface;
use Freezemage\Container\Contract\ResolverInterface;
use Freezemage\Container\Exception\ContainerException;
use Freezemage\Container\Generator\CachingGenerator;
use Freezemage\Container\Generator\ConstructorGenerator;
use Freezemage\Container\Generator\FactoryGenerator;
use Freezemage\Container\Instantiator\CloningInstantiator;
use Freezemage\Container\Resolver\CachingResolver;
use Freezemage\Container\Resolver\ConstructorResolver;
use Freezemage\Container\Storage\Alias;
use Freezemage\Container\Storage\Definitions;
use Freezemage\Container\Storage\PrototypeCache;
use Psr\Container\ContainerInterface;
use ReflectionClass;


class Container implements ContainerInterface
{
    private Alias $alias;
    private GeneratorInterface $generator;
    private InstantiatorInterface $instantiator;
    private PrototypeCache        $prototypeCache;
    private ResolverInterface     $resolver;
    private Definitions $definitions;

    public function __construct()
    {
        $this->alias = new Alias();
        $this->prototypeCache = new PrototypeCache();
        $this->definitions = new Definitions();
    }

    public function get(string $id)
    {
        $className = $this->alias->get($id);

        if ($this->prototypeCache->has($className)) {
            $prototype = $this->prototypeCache->get($className);
        } else {
            $reflection = new ReflectionClass($className);

            if (!$this->definitions->has($className)) {
                $dependencies = array_map(
                        fn(string $id): object => $this->get($id),
                        $this->getResolver()->resolve($reflection)
                );
            } else {
                $dependencies = $this->definitions->get($className);
            }

            $prototype = $this->getGenerator()->generate($reflection, $dependencies);

            $this->prototypeCache->set($className, $prototype);
        }

        return $this->getInstantiator()->instantiate($prototype);
    }

    public function getResolver(): ResolverInterface
    {
        if (!isset($this->resolver)) {
            throw new ContainerException('Resolver is not set.');
        }

        if (!($this->resolver instanceof CachingResolver)) {
            $this->resolver = new CachingResolver($this->resolver);
        }

        return $this->resolver;
    }

    public function setResolver(ResolverInterface $resolver): void
    {
        $this->resolver = $resolver;
    }

    public function getGenerator(): GeneratorInterface
    {
        if (!isset($this->generator)) {
            throw new ContainerException('Generator is not set.');
        }

        return $this->generator;
    }

    public function setGenerator(GeneratorInterface $generator): void
    {
        $this->generator = $generator;
    }

    public function getInstantiator(): InstantiatorInterface
    {
        if (!isset($this->instantiator)) {
            throw new ContainerException('Instantiator is not set.');
        }

        return $this->instantiator;
    }

    public function setInstantiator(InstantiatorInterface $instantiator): void
    {
        $this->instantiator = $instantiator;
    }

    public function has(string $id): bool
    {
        $className = $this->alias->get($id);
        return $this->prototypeCache->has($className);
    }

    public function alias(string $id, string $className): Container
    {
        $this->alias->register($id, $className);
        return $this;
    }

    public function define(string $id, array $dependencies = array()): Container
    {
        $className = $this->alias->get($id);
        $this->definitions->register($className, $dependencies);
        return $this;
    }
}