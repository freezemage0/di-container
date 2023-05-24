<?php


namespace Freezemage\Container;


use Freezemage\Container\Contract\GeneratorInterface;
use Freezemage\Container\Contract\InstantiatorInterface;
use Freezemage\Container\Contract\ResolverInterface;
use Freezemage\Container\Generator\ConstructorGenerator;
use Freezemage\Container\Instantiator\CloningInstantiator;
use Freezemage\Container\Resolver\CachingResolver;
use Freezemage\Container\Resolver\ConstructorResolver;
use Freezemage\Container\Storage\Alias;
use Freezemage\Container\Storage\PrototypeCache;
use Psr\Container\ContainerInterface;
use ReflectionClass;


class Container implements ContainerInterface
{
    private Alias $alias;
    private GeneratorInterface $generator;
    private InstantiatorInterface $instantiator;
    private PrototypeCache $cache;
    private ResolverInterface $resolver;

    public function __construct()
    {
        $this->alias = new Alias();
        $this->cache = new PrototypeCache();
    }

    public function get(string $id)
    {
        $className = $this->alias->get($id);

        if ($this->cache->has($className)) {
            $prototype = $this->cache->get($className);
        } else {
            $reflection = new ReflectionClass($className);

            $dependencies = array_map(
                fn(string $id): object => $this->get($id),
                $this->getResolver()->resolve($reflection)
            );
            $prototype = $this->getGenerator()->generate($reflection, $dependencies);

            $this->cache->set($className, $prototype);
        }

        return $this->getInstantiator()->instantiate($prototype);
    }

    public function getResolver(): ResolverInterface
    {
        if (!isset($this->resolver)) {
            $this->resolver = new ConstructorResolver();
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
            $this->generator = new ConstructorGenerator();
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
            $this->instantiator = new CloningInstantiator();
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
        return $this->cache->has($className);
    }

    public function alias(string $id, string $className): Container
    {
        $this->alias->register($id, $className);
        return $this;
    }
}