<?php


namespace Freezemage\Container\Resolver;


use Freezemage\Container\Contract\ResolverInterface;
use ReflectionClass;


class ConfigurationResolver implements ResolverInterface
{
    private array $configuration;
    private ResolverInterface $fallback;

    public function __construct(array $configuration = array())
    {
        $this->configuration = $configuration;
    }

    public function setFallback(ResolverInterface $fallback): void
    {
        $this->fallback = $fallback;
    }

    public function getFallback(): ResolverInterface
    {
        if (!isset($this->fallback)) {
            $this->fallback = new NullResolver();
        }

        return $this->fallback;
    }

    public function resolve(ReflectionClass $reflection): array
    {
        $className = $reflection->getName();
        $fallback = $this->getFallback();

        if (array_key_exists($className, $this->configuration)) {
            return $this->configuration[$className]['dependencies'] ?? $fallback->resolve($reflection);
        }

        foreach ($this->configuration as $settings) {
            if (empty($settings['className']) || $settings['className'] != $className) {
                continue;
            }

            return $settings['dependencies'] ?? $fallback->resolve($reflection);
        }
    }
}