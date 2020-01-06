<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

use const E_USER_WARNING;

/**
 * Class Combine.
 *
 * @template TKey
 * @template TValue
 */
final class Combine implements Operation
{
    /**
     * @var array<array<TKey, TValue>>
     */
    private $keys;

    /**
     * Combine constructor.
     *
     * @param mixed ...$keys
     */
    public function __construct(...$keys)
    {
        $this->keys = $keys;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $keys = $this->keys;

        return static function () use ($keys, $collection): Generator {
            [$keys] = $keys;

            $original = new IterableIterator($collection);
            $keysIterator = new ArrayIterator($keys);

            while ($original->valid() && $keysIterator->valid()) {
                yield $keysIterator->current() => $original->current();

                $original->next();
                $keysIterator->next();
            }

            $predicate1 = (true === $original->valid() && false === $keysIterator->valid());
            $predicate2 = (false === $original->valid() && true === $keysIterator->valid());

            if ($predicate1 || $predicate2) {
                trigger_error('Both keys and values must have the same amount of items.', E_USER_WARNING);
            }
        };
    }
}
