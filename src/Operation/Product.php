<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

use function count;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @extends AbstractOperation<TKey, T, Generator<int, array<int, T>>>
 * @implements Operation<TKey, T, Generator<int, array<int, T>>>
 */
final class Product extends AbstractOperation implements Operation
{
    /**
     * Product constructor.
     *
     * @param iterable<TKey, T> ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $this->storage = [
            'iterables' => $iterables,
            'cartesian' =>
                /**
                 * @return Generator<int, array<int, T>>
                 */
                function (array $input): Generator {
                    return $this->cartesian($input);
                },
        ];
    }

    // phpcs:disable
    /**
     * @return Closure(\Iterator<TKey, T>, array<int, iterable<TKey, T>>, callable(array<int, iterable<TKey, T>>): (array<int, T>)): Generator<int, array<int, T>>
     */
    // phpcs:enable
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param array<int, iterable<TKey, T>> $iterables
             * @param callable(array<int, iterable<TKey, T>>): (array<int, T>) $cartesian
             *
             * @return \Generator<mixed, mixed, mixed, void>
             */
            static function (Iterator $iterator, array $iterables, callable $cartesian): Generator {
                $its = [$iterator];

                foreach ($iterables as $iterable) {
                    $its[] = new IterableIterator($iterable);
                }

                return yield from $cartesian($its);
            };
    }

    /**
     * @param array<int, iterable<TKey, T>> $iterators
     *
     * @return Generator<int, array<int, T>>
     */
    private function cartesian(array $iterators): Generator
    {
        $iterator = array_pop($iterators);

        if (null === $iterator) {
            return yield [];
        }

        foreach ($this->cartesian($iterators) as $item) {
            foreach ($iterator as $value) {
                yield $item + [count($item) => $value];
            }
        }
    }
}
