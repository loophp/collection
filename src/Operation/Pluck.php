<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use ArrayAccess;
use drupol\collection\Contract\Collection;
use drupol\collection\Contract\Operation;

/**
 * Class Pluck.
 */
final class Pluck implements Operation
{
    /**
     * @var mixed
     */
    private $default;

    /**
     * @var array|string
     */
    private $key;

    /**
     * Pluck constructor.
     *
     * @param array|string $key
     * @param mixed $default
     */
    public function __construct($key, $default)
    {
        $this->key = $key;
        $this->default = $default;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $key = $this->key;
        $default = $this->default;

        $operation = $this;

        return static function () use ($key, $default, $collection, $operation) {
            $key = \is_string($key) ? \explode('.', \trim($key, '.')) : $key;

            foreach ($collection as $value) {
                yield $operation->pick($collection, $value, $key, $default);
            }
        };
    }

    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param iterable $collection
     * @param mixed $target
     * @param array $key
     * @param mixed $default
     *
     * @throws \ReflectionException
     *
     * @return mixed
     */
    private function pick(iterable $collection, $target, array $key, $default = null)
    {
        while (null !== $segment = \array_shift($key)) {
            if ('*' === $segment) {
                if (false === \is_iterable($target)) {
                    return $default;
                }

                $result = [];

                foreach ($target as $item) {
                    $result[] = $this->pick($collection, $item, $key);
                }

                return \in_array('*', $key, true) ? (new Collapse())->on($result) : $result;
            }

            if ((true === \is_array($target)) && (true === \array_key_exists($segment, $target))) {
                $target = $target[$segment];
            } elseif (($target instanceof ArrayAccess) && (true === $target->offsetExists($segment))) {
                $target = $target[$segment];
            } elseif ($target instanceof Collection) {
                $target = (new Get($segment, $default))->on($target);
            } elseif ((true === \is_object($target)) && (true === \property_exists($target, $segment))) {
                $target = (new \ReflectionClass($target))->getProperty($segment)->getValue($target);
            } else {
                $target = $default;
            }
        }

        return $target;
    }
}
