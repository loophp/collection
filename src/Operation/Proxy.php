<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Collection;

/**
 * Class Proxy.
 */
final class Proxy extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$method, $proxyMethod, $parameters] = $this->parameters;

        $callback = static function ($value) use ($proxyMethod, $parameters) {
            $reflection = new \ReflectionClass($value);

            if (false === $reflection->hasMethod($proxyMethod)) {
                throw new \InvalidArgumentException(\sprintf('Proxy method %s does not exist.', $proxyMethod));
            }

            return $reflection
                ->getMethod($proxyMethod)
                ->invoke($value, ...$parameters);
        };

        $reflection = new \ReflectionClass($collection);

        if (false === $reflection->hasMethod($method)) {
            throw new \InvalidArgumentException(\sprintf('Method %s does not exist.', $method));
        }

        return Collection::with($reflection
            ->getMethod($method)
            ->invoke($collection->rebase(), $callback));
    }
}
