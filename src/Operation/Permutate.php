<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @extends AbstractOperation<TKey, T, Generator<int, array<int, T>>>
 * @implements Operation<TKey, T, Generator<int, array<int, T>>>
 */
final class Permutate extends AbstractOperation implements Operation
{
    /**
     * @return Closure(\Iterator<TKey, T>): Generator<int, array<int, T>>
     */
    public function __invoke(): Closure
    {
        $getPermutations =
            /**
             * @param array<int, T> $dataset
             *
             * @return Generator<int, array<int, T>>
             */
            function (array $dataset): Generator {
                return $this->getPermutations($dataset);
            };

        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<int, array<int, T>>
             */
            static function (Iterator $iterator) use ($getPermutations): Generator {
                return yield from $getPermutations(iterator_to_array($iterator));
            };
    }

    /**
     * @param array<int, T> $dataset
     *
     * @return Generator<int, array<int, T>>
     */
    private function getPermutations(array $dataset): Generator
    {
        foreach ($dataset as $key => $firstItem) {
            $remaining = $dataset;

            array_splice($remaining, $key, 1);

            if ([] === $remaining) {
                yield [$firstItem];

                continue;
            }

            foreach ($this->getPermutations($remaining) as $permutation) {
                array_unshift($permutation, $firstItem);

                yield $permutation;
            }
        }
    }
}
