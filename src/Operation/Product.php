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
 */
final class Product extends AbstractOperation implements Operation
{
    /**
     * @param iterable<mixed> ...$iterables
     * @psalm-param \Iterator<TKey, T> ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $this->storage = [
            'iterables' => $iterables,
            'cartesian' =>
                /**
                 * @param array<int, mixed> $input
                 * @psalm-param array<int, \Iterator<TKey, T>> $input
                 *
                 * @psalm-return \Generator<array<int, T>>
                 */
                function (array $input): Generator {
                    return $this->cartesian($input);
                },
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param array<int, iterable<TKey, T>> $iterables
             *
             * @psalm-return \Generator<int, array<int, T>>
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
     * @param array<int, iterable> $iterators
     * @psalm-param array<int, \Iterator<TKey, T>> $iterators
     *
     * @psalm-return \Generator<int, array<int, T>>
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
