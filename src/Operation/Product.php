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
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Product extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        $cartesian = function (array $input): Generator {
            return $this->cartesian($input);
        };

        return static function (iterable ...$iterables) use ($cartesian): Closure {
            return static function (Iterator $iterator) use ($cartesian, $iterables): Generator {
                $its = [$iterator];

                foreach ($iterables as $iterable) {
                    $its[] = new IterableIterator($iterable);
                }

                return yield from $cartesian($its);
            };
        };
    }

    /**
     * @param array<int, iterable> $iterators
     * @psalm-param array<int, Iterator<TKey, T>> $iterators
     *
     * @psalm-return Generator<int, array<int, T>>
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
