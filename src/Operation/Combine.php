<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Iterator\ClosureIterator;

/**
 * Class Combine.
 */
final class Combine extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$keys] = $this->parameters;

        return static function () use ($keys, $collection): \Generator {
            $original = new ClosureIterator(
                static function () use ($collection) {
                    foreach ($collection as $key => $value) {
                        yield $key => $value;
                    }
                }
            );
            $keysIterator = new \ArrayIterator($keys);

            for (; true === ($original->valid() && $keysIterator->valid()); $original->next(), $keysIterator->next()
                ) {
                yield $keysIterator->current() => $original->current();
            }

            if ((true === $original->valid() && false === $keysIterator->valid()) ||
                    (false === $original->valid() && true === $keysIterator->valid())
                ) {
                \trigger_error('Both keys and values must have the same amount of items.', \E_USER_WARNING);
            }
        };
    }
}
