<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Proxy.
 */
final class Proxy extends Operation
{
    /**
     * Proxy constructor.
     *
     * @param string $method
     * @param \Closure|string $proxyMethod
     * @param mixed ...$parameters
     */
    public function __construct(string $method, $proxyMethod, ...$parameters)
    {
        $params = [
            'method' => $method,
            'proxyMethod' => $proxyMethod,
            'parameters' => $parameters,
        ];

        parent::__construct(...\array_values($params));
    }

    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$method, $proxyMethod, $parameters] = $this->parameters;

        $callback = null;

        if ($proxyMethod instanceof \Closure) {
            $callback = static function ($value) use ($proxyMethod, $parameters) {
                return $proxyMethod($value, ...$parameters);
            };
        }

        if (\is_string($proxyMethod)) {
            $callback = static function ($value) use ($proxyMethod, $parameters) {
                $reflection = new \ReflectionClass($value);

                if (false === $reflection->hasMethod($proxyMethod)) {
                    throw new \InvalidArgumentException(\sprintf('Proxy method %s does not exist.', $proxyMethod));
                }

                return $reflection
                    ->getMethod($proxyMethod)
                    ->invoke($value, ...$parameters);
            };
        }

        $reflection = new \ReflectionClass($collection);

        if (false === $reflection->hasMethod($method)) {
            throw new \InvalidArgumentException(\sprintf('Method %s does not exist.', $method));
        }

        return $collection::with(
            static function () use ($reflection, $method, $collection, $callback) {
                return $reflection
                    ->getMethod($method)
                    ->invoke($collection, $callback);
            }
        );
    }
}
