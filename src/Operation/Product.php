<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

use function count;

final class Product extends AbstractOperation implements Operation
{
    /**
     * Product constructor.
     *
     * @param iterable<mixed> ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $this->storage = [
            'iterables' => $iterables,
            'cartesian' => function (array $input): Generator {
                return $this->cartesian($input);
            },
        ];
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @param array<int, iterable> $iterables
             * @param iterable $collection
             * @param callable $cartesian
             */
            static function (iterable $collection, array $iterables, callable $cartesian): Generator {
                $its = [$collection];

                foreach ($iterables as $iterable) {
                    $its[] = new IterableIterator($iterable);
                }

                yield from $cartesian($its);
            };
    }

    /**
     * @param array<iterable> $iterators
     *
     * @return Generator<array<mixed>>
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
