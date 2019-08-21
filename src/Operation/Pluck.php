<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use ArrayAccess;
use drupol\collection\Collection;
use drupol\collection\Contract\Collection as CollectionInterface;

/**
 * Class Pluck.
 */
final class Pluck extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection): \IteratorAggregate
    {
        [$key, $default] = $this->parameters;
        $operation = $this;

        return Collection::with(
            static function () use ($key, $default, $collection, $operation) {
                $key = \is_string($key) ? \explode('.', \trim($key, '.')) : $key;

                foreach ($collection as $item) {
                    yield $operation->pick($item, $key, $default);
                }
            }
        );
    }

    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param mixed $target
     * @param array $key
     * @param mixed $default
     *
     * @throws \ReflectionException
     *
     * @return mixed
     */
    private function pick($target, array $key, $default = null)
    {
        while (null !== $segment = \array_shift($key)) {
            if ('*' === $segment) {
                if (!\is_array($target)) {
                    return $default;
                }

                $result = [];

                foreach ($target as $item) {
                    $result[] = $this->pick($item, $key);
                }

                return \in_array('*', $key, true) ? Collection::with($result)->collapse() : $result;
            }

            if ((true === \is_array($target)) && (true === \array_key_exists($segment, $target))) {
                $target = $target[$segment];
            } elseif (($target instanceof ArrayAccess) && (true === $target->offsetExists($segment))) {
                $target = $target[$segment];
            } elseif ($target instanceof CollectionInterface) {
                $target = $target->get($segment, $default);
            } elseif ((true === \is_object($target)) && (true === \property_exists($target, $segment))) {
                $target = (new \ReflectionClass($target))->getProperty($segment)->getValue($target);
            } else {
                $target = $default;
            }
        }

        return $target;
    }
}
