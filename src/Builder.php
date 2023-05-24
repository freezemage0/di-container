<?php


namespace Freezemage\Container;


use Freezemage\Container\Factory\GeneratorFactory;
use Freezemage\Container\Factory\InstantiatorFactory;
use Freezemage\Container\Factory\ResolverFactory;
use Freezemage\Container\Resolver\ConfigurationResolver;


final class Builder
{
    private GeneratorFactory $generatorFactory;
    private InstantiatorFactory $instantiatorFactory;
    private ResolverFactory $resolverFactory;

    private string $generatorType;
    private string $instantiatorType;
    private string $resolverType;

    public function __construct(
        ?GeneratorFactory $generatorFactory = null,
        ?InstantiatorFactory $instantiatorFactory = null,
        ?ResolverFactory $resolverFactory = null
    ) {
        $this->generatorFactory = $generatorFactory ?? new GeneratorFactory();
        $this->instantiatorFactory = $instantiatorFactory ?? new InstantiatorFactory();
        $this->resolverFactory = $resolverFactory ?? new ResolverFactory();
    }

    public function fromConfig(array $config): Container
    {
        if (array_key_exists('prototype', $config)) {
            $prototype = $config['prototype'];
            if (array_key_exists('instantiator', $prototype)) {
                $this->setInstantiatorType($prototype['instantiator']);
            }

            if (array_key_exists('generator', $prototype)) {
                $this->setGeneratorType($prototype['generator']);
            }
        }

        if (array_key_exists('resolver', $config)) {
            $resolver = $config['resolver'];
            if (array_key_exists('fallback', $resolver)) {
                $this->setResolverType($resolver['fallback']);
            }
        }

        $container = $this->build();
        if (array_key_exists('dependencies', $config)) {
            $configurationResolver = new ConfigurationResolver($config['dependencies']);
            $configurationResolver->setFallback($this->resolverFactory->create($this->resolverType));
            $container->setResolver($configurationResolver);
        }

        return $container;
    }

    public function setGeneratorType(string $generatorType): void
    {
        $this->generatorType = $generatorType;
    }

    public function setInstantiatorType(string $instantiatorType): void
    {
        $this->instantiatorType = $instantiatorType;
    }

    public function setResolverType(string $resolverType): void
    {
        $this->resolverType = $resolverType;
    }

    public function build(): Container
    {
        $container = new Container();
        $container->setGenerator($this->generatorFactory->create($this->generatorType));
        $container->setInstantiator($this->instantiatorFactory->create($this->instantiatorType));
        $container->setResolver($this->resolverFactory->create($this->resolverType));

        return $container;
    }
}